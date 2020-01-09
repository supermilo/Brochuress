<?php
/**
 * The template for displaying the footer.
 *
 * @package superfit
 */

?>  
            </div>

            <footer class="footer" role="contentinfo">
                 <?php
                /**
                 * Functions hooked in to superfit_footer action.
                 *
                 * @hooked superfit_template_copyright -10
                 */ 
                    do_action('superfit_footer'); 
                ?>
            </footer>
        <span class="pwmodal-overlay"></span>
        <?php wp_footer(); ?>
    </body>

</html>