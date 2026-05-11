<?php
declare(strict_types=1);

require_once __DIR__ . '/data.php';

const AI_SEED_CATEGORIES = ['Philosophy', 'Logic & Reason', 'Scientific Method', 'Historical Archives', 'Daily Challenges'];

function ai_seed_categories(): array
{
    return AI_SEED_CATEGORIES;
}

function ai_seed_clamp_count(int $count): int
{
    return max(1, min(5, $count));
}

function ai_seed_length_words(string $length): int
{
    return match ($length) {
        'short' => 180,
        'long' => 520,
        default => 320,
    };
}

function ai_seed_clean_text(mixed $value, int $maxLength): string
{
    $text = trim(strip_tags((string) $value));
    $text = preg_replace('/\s+/', ' ', $text) ?? '';
    if (strlen($text) > $maxLength) {
        $text = substr($text, 0, $maxLength - 1);
        $text = preg_replace('/\s+\S*$/', '', $text) ?? $text;
    }
    return trim($text);
}

function ai_seed_extract_json(string $text): ?array
{
    $text = trim($text);
    if (str_starts_with($text, '```')) {
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text) ?? $text;
        $text = preg_replace('/\s*```$/', '', $text) ?? $text;
    }

    $decoded = json_decode($text, true);
    if (is_array($decoded)) {
        return $decoded;
    }

    $start = strpos($text, '[');
    $end = strrpos($text, ']');
    if ($start !== false && $end !== false && $end > $start) {
        $decoded = json_decode(substr($text, $start, $end - $start + 1), true);
        return is_array($decoded) ? $decoded : null;
    }

    return null;
}

function ai_seed_normalize_items(array $items, string $category): array
{
    $normalized = [];
    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }
        $title = ai_seed_clean_text($item['title'] ?? '', 120);
        $summary = ai_seed_clean_text($item['summary'] ?? '', 260);
        $body = trim(strip_tags((string) ($item['body'] ?? '')));
        $body = preg_replace("/\r\n|\r/", "\n", $body) ?? '';
        $body = preg_replace("/\n{3,}/", "\n\n", $body) ?? $body;
        $body = trim(strlen($body) > 6000 ? substr($body, 0, 6000) : $body);
        if ($title === '' || $summary === '' || $body === '') {
            continue;
        }
        $normalized[] = [
            'title' => $title,
            'category' => $category,
            'summary' => $summary,
            'body' => $body,
        ];
    }
    return $normalized;
}

function gemini_seed_generate(array $input): array
{
    $apiKey = getenv('GEMINI_API_KEY') ?: '';
    if ($apiKey === '') {
        return ['ok' => false, 'error' => 'GEMINI_API_KEY is not configured.', 'items' => []];
    }
    if (!function_exists('curl_init')) {
        return ['ok' => false, 'error' => 'PHP cURL is required for Gemini API requests.', 'items' => []];
    }

    $topic = ai_seed_clean_text($input['topic'] ?? '', 180);
    $category = (string) ($input['category'] ?? '');
    $tone = ai_seed_clean_text($input['tone'] ?? 'clear academic', 80);
    $level = ai_seed_clean_text($input['level'] ?? 'undergraduate students', 80);
    $count = ai_seed_clamp_count((int) ($input['count'] ?? 1));
    $words = ai_seed_length_words((string) ($input['length'] ?? 'medium'));

    if ($topic === '') {
        return ['ok' => false, 'error' => 'Topic is required.', 'items' => []];
    }
    if (!in_array($category, ai_seed_categories(), true)) {
        return ['ok' => false, 'error' => 'Choose a valid category.', 'items' => []];
    }

    $model = getenv('GEMINI_MODEL') ?: 'gemini-2.5-flash';
    $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/' . rawurlencode($model) . ':generateContent';
    $prompt = <<<PROMPT
Generate {$count} original Spring Wisdom reading archive item(s).

Topic: {$topic}
Category: {$category}
Audience: {$level}
Tone: {$tone}
Approximate body length per item: {$words} words

Return ONLY a valid JSON array. Each object must have exactly:
- "title": concise title
- "category": "{$category}"
- "summary": one sentence, max 32 words
- "body": educational reading text with no markdown headings and no citations invented as facts

Do not include code fences, commentary, or extra keys.
PROMPT;

    $payload = [
        'contents' => [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => $prompt],
                ],
            ],
        ],
        'generationConfig' => [
            'temperature' => 0.7,
            'responseMimeType' => 'application/json',
        ],
    ];

    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-goog-api-key: ' . $apiKey,
        ],
        CURLOPT_TIMEOUT => 45,
    ]);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || $response === '') {
        return ['ok' => false, 'error' => 'Gemini request failed: ' . ($curlError ?: 'empty response'), 'items' => []];
    }

    $decoded = json_decode($response, true);
    if ($status < 200 || $status >= 300) {
        $message = $decoded['error']['message'] ?? 'Gemini API returned HTTP ' . $status . '.';
        return ['ok' => false, 'error' => $message, 'items' => []];
    }

    $text = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? '';
    $items = is_string($text) ? ai_seed_extract_json($text) : null;
    if (!$items) {
        return ['ok' => false, 'error' => 'Gemini response was not valid archive JSON.', 'items' => []];
    }

    $normalized = array_slice(ai_seed_normalize_items($items, $category), 0, $count);
    if (!$normalized) {
        return ['ok' => false, 'error' => 'Gemini response did not contain usable content items.', 'items' => []];
    }

    return ['ok' => true, 'error' => '', 'items' => $normalized];
}
