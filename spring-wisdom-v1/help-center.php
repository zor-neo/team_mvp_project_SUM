<?php
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Help Center';
$active = '';
require __DIR__ . '/includes/header.php';
?>
<section class="sw-section">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="sw-panel">
                    <span class="badge sw-badge mb-3">Help</span>
                    <h1 class="h2 fw-bold">Help Center</h1>
                    <div class="accordion mt-3" id="helpAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#helpBrowse">How do I find readings?</button></h2>
                            <div id="helpBrowse" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion"><div class="accordion-body">Use Browse for curated highlights or All Archives for full filtering by category, author, and newest or oldest sorting.</div></div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#helpReport">How do I report content?</button></h2>
                            <div id="helpReport" class="accordion-collapse collapse" data-bs-parent="#helpAccordion"><div class="accordion-body">Open a reading, choose Report Content, select a reason category, and type a clear explanation.</div></div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#helpAuthor">How do I become an author?</button></h2>
                            <div id="helpAuthor" class="accordion-collapse collapse" data-bs-parent="#helpAccordion"><div class="accordion-body">Normal users can submit an Author Request from the navbar or account dropdown. Admin reviews the request before promotion.</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
