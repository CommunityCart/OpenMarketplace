<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <?php
            /*
            <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->
        */
        ?>
        <!-- Sidebar Menu -->
        <div id="sidebar-links">
            <?php

                    if(isset($menus)) {

                       echo $menus;

                    }
                ?>
        </div>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
