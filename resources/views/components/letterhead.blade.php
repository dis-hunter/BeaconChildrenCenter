<style>
    @page  {
        size: A4;
        margin: 0;
        counter-reset: page;
    }

    .page-container {
        width: 100%;
        max-width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        background-color: white;
        display: flex;
        flex-direction: column;
        page-break-inside: avoid;
        counter-increment: page;
        page-break-after: always;
    }

    .page-number:before {
        content: counter(page);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #d1d5db;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .logo-section {
        width: 33.333%;
        padding-right: 1rem;
        display: flex;
        justify-content: center;
    }

    .logo-image {
        width: 200px;
        height: auto;
    }

    .contact-details {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.5rem;
        text-align: left;
    }

    .content-section {
        flex-grow: 1;
        margin-bottom: 1rem;
    }

    .content-margin {
        margin-top: 1rem;
    }

    .footer {
        border-top: 2px solid #d1d5db;
        padding-top: 1rem;
        margin-top: auto;
        font-size: 0.75rem;
        color: #6b7280;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
    }

    .footer-right {
        text-align: right;
    }

    @media print {
        body * {
            margin: 0;
            padding: 0;
        }

        img {
            display: block !important;
        }

        .page-container {
            margin: 0;
            padding: 1.5rem;
            page-break-after: always;
        }

    }
    .title{
        text-align: center;
    }
</style>
<div class="page-container">
    <div class="header">
        <div class="logo-section">
            <img src="{{ asset('images/logo-transparent.webp') }}"
                 class="logo-image"
                 alt="{{ config('app.name') }} Logo"
            >
        </div>
        <div class="contact-details">
            <p>Feruzi Towers, Kiambu Road, Thindigua</p>
            <p>P.O. Box 1609 - 00232</p>
            <p>Ruiru, Kenya.</p>
            <p>Tel: 0115 188 415 | 0780 626 990 | 0722 322 363</p>
            <p>Email: beaconchildrencenter@gmail.com</p>
        </div>
    </div>
    <div class="content-section">
        <div class="content-margin">
            {{$slot}}
        </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <div>
                <p>Authorized Healthcare Provider</p>
            </div>
            <div class="text-center">
                <p>Page <span class="page-number"></span></p>
            </div>
            <div class="footer-right">
                <p>Printed on: {{ now()->format('d F Y') }}</p>
            </div>
        </div>
    </footer>
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', () => {--}}
{{--            function setupPageNumbers() {--}}
{{--                const pageContainers = document.querySelectorAll('.page-container');--}}
{{--                const totalPages = pageContainers.length;--}}

{{--                // Enhanced page numbering--}}
{{--                pageContainers.forEach((container, index) => {--}}
{{--                    const pageNumberElement = container.querySelector('.page-number');--}}
{{--                    if (pageNumberElement) {--}}
{{--                        pageNumberElement.dataset.page = index + 1;--}}
{{--                        pageNumberElement.dataset.totalPages = pageContainers.length;--}}
{{--                        pageNumberElement.setAttribute('data-total-pages', totalPages);--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}

{{--            // Run on load and print--}}
{{--            setupPageNumbers();--}}
{{--            window.addEventListener('beforeprint', setupPageNumbers);--}}
{{--        });--}}
{{--        </script>--}}
</div>
