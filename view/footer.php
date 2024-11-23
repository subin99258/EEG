<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to determine if the current page is the homepage
function is_homepage() {
    $script_filename = $_SERVER['PHP_SELF'];
    $request_uri = $_SERVER['REQUEST_URI'];
    
    return ($script_filename == '/unisq-eeg-publications-platform/index.php' 
            && $request_uri == '/unisq-eeg-publications-platform/index.php') 
            || $request_uri == '/unisq-eeg-publications-platform/';
}
?>

<footer id="usq_footer" class="footer container-fluid" role="contentinfo">
    <div class="region region-footer">
        <section id="block-corporatefooter" class="container-fluid block block-simple-block block-simple-blockfooter clearfix">
            <div class="block-wrapper">
                
                <div class="brand-acknowledgement">
                    <div class="container">
                        <div class="row">
                            <div class="offset-md-1 col-md-10 text-align-center">
                                The University of Southern Queensland acknowledges the traditional custodians of the lands and waterways where the University is located. Further, we acknowledge the cultural diversity of Aboriginal and Torres Strait Islander peoples and pay respect to Elders past, present and future.
                            </div>
                        </div>
                    </div>
                </div>

                
                
                      

                
                <div class="brand-page-footer">
                    <div class="container">
                        <div class="footer-content d-flex justify-content-between align-items-center">
                            <img alt="University of Southern Queensland" 
                                src="https://unisq.edu.au/Content/USQ/Charlie/Images/unisq-logo-acronym-white.svg" 
                                style="max-width: 100px; height: auto; display: block; margin-right: 50px;">

                            <div class="text-white text-center">
                                &copy; <?php echo date("Y"); ?> University of Southern Queensland. UniSQ is a member of the Regional Universities Network.<br>
                                CRICOS: QLD 00244B, NSW 02225M TEQSA: PRV12081
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- Internal CSS Styling -->
    <style>
        /* General Colors */
        :root {
            --col1: #FFB448;
            --col2: #3C2D4D;
            --text: #D8F3DC;
        }

        #usq_footer.footer.container-fluid {
            font-size: 1rem;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        /* Brand Acknowledgement */
        .brand-acknowledgement {
            background-color: var(--col1);
            color: var(--col2);
            padding: 20px 0;
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Footer Content Wrapper */
        .c-footer__content-wrapper {
            background-color: var(--col2);
            color: var(--text);
            padding: 20px 0;
        }

        /* Footer Links Styling */
        .c-footer__content-col ul {
            list-style: none;
            padding: 0;
        }

        .c-footer__content-col ul li,
        .list-inline li {
            display: inline;
            padding: 0 10px;
        }

        .c-footer__content-col ul li a,
        .list-inline li a {
            color: var(--text);
            text-decoration: none;
        }

        .c-footer__content-col ul li a:hover,
        .list-inline li a:hover {
            text-decoration: underline;
        }

        /* Brand Page Footer */
        .brand-page-footer {
            background-color: var(--col2);
            color: var(--text);
            padding: 20px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text);
        }

        /* Ensure Full Width for .region-footer */
        .region-footer {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</footer>
