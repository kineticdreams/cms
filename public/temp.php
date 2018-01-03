<?php eval("?>".$content = find_content_by_link('home')."<?"); ?>
         <section class="content">
             <h2 class="spacing"><?php echo eval('?>'.$content['h1'].'<?'); ?></h2>
             <article>
                <p class="dropCap">Cras ultrices nibh at odio ullamcorper, a commodo erat interdum. Aliquam ac elit at arcu viverra consectetur vel eu lectus. Quisque nec justo in mauris mattis venenatis at non orci. Integer dignissim aliquet nunc vitae posuere. Morbi accumsan, magna vel sodales vestibulum, justo metus aliquam erat, ut tempor diam justo ut dui. Donec pharetra urna at purus tristique interdum. Integer pellentesque molestie erat. Pellentesque eu elementum diam, at vulputate purus. Integer in lobortis urna. Vestibulum sodales est vitae magna pellentesque, sollicitudin feugiat nisi molestie. Vivamus tempus nunc eget diam molestie porta. Quisque vitae libero magna. Etiam quis pellentesque arcu. Proin elementum posuere mattis.</p>
                <p class="dropCap">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
             </article>

         </section>

         <aside class="sidebar">
             <article>
                <p class="dropCap">Praesent tempus, magna ac rutrum porttitor, lectus eros finibus erat, ac imperdiet ipsum purus sit amet lectus. Morbi id erat sagittis, hendrerit est at, dictum arcu. Suspendisse tincidunt leo quis purus aliquet pellentesque. Nunc vel porttitor urna. Quisque in feugiat libero, eget finibus ipsum. Aliquam tristique id lectus vitae condimentum. Nam ut posuere neque. Cras id tellus urna. Donec eu efficitur nisl. Fusce mauris risus, condimentum eget maximus eu, tincidunt tincidunt velit.</p>


             </article>

             <p class="spacing small atBottom">Page Updated: <?php echo eval("?>".date('d/m/Y H:i:s', $content['dtg'])."<?"); ?></p>

         </aside>
