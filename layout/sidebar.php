<aside class="main-sidebar" style="background:#910007;">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <?php if($picture){ ?>
            <img src="<?php echo $picture; ?>" class="img-circle" alt="User Image">
            <?php }else{ ?>
              <img src="./images/17-1.jpg" class="img-circle" alt="User Image">
            <?php }?>
          </div>
          <div class="pull-left info">
            <p style="color:#e0e0e0;"><?php echo $agent_name; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

          <li id="dashbord_list" style="border-bottom:1px solid gray; padding:5px;">
            <a href="index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <li style="border-bottom:1px solid gray; padding:5px;">
              <span  style="text-align:center; color:white; "><span id="quick_text">Quick Searcher</span> <img src="./img/chinaFlag.png" style="width:30px; position:relative; top:-3px; left:10px;"> </span>
              <form method="get" action="searcherJobOrder.php?">
              <input name="JO"  placeholder="J.O# / CLIENT or SUPPLIER NAME" style="width:100%; font-size:12px; text-align:center; border:1px solid gray; padding:15px;">
              <br><br>
        </form>
          </li>

          <center>
          <div style="width:100%; height:20px;background:#CECAC6; "><span style=" color:#630000; font-weight:600; font-size:14px;">CARGOS</span></div></center>
          <li id="accounts_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-users"></i> <span style="font-size:11px; ">Accounts</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createAccount.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search"  href="searchAccount.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

        
          <li id="quotations_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px; ">Quotations</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right" ></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createQuotation.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchQuotation.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          <li id="warehouses_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
          <a href="#" style="height:25px; position:relative; top:-10px;">
            <i class="fa fa-home"></i> <span style="font-size:11px; ">Warehouse</span>
            <span class="pull-right-container" style="top:22px;">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a id="create" href="createWarehouse.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
            <li><a id="search" href="searchWarehouse.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
          </ul>
          </li>

          <li id="loadingguide_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-home"></i> <span style="font-size:11px; ">Loading Guide</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createLodingGuide.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchLodingGuide.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>
          <li id="pre_loading_plan" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-home"></i> <span style="font-size:11px; ">PRE LOADING PLAN</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createPreLodingPlan.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchPreLodingPlan.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>
          <li id="bill_menu" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-money"></i> <span style="font-size:11px; ">Bill</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="sub_menu_create"><a  href="#" style="font-size:11px;"><i class="fa fa-plus"></i>Create</a>
                <ul class="treeview-menu">
                  <li><a id="create_bills_menu" href="createBill.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Bills</a></li>
                  <li><a id="create_payment_menu" href="createPayment.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Payment</a></li>
                </ul>
              </li>
                <li><a class="sub_search_create" href="#" style="font-size:11px;"><i class="fa fa-plus"></i>Search</a>
                  <ul class="treeview-menu">
                    <li><a id="search_bills_menu" href="searchBill.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Bills</a></li>
                    <li><a id="search_payment_menu" href="searchPayment.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Payment</a></li>
                  </ul>
              </li>
            </ul>
          </li>          
          <li id="shipment" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-ship"></i> <span style="font-size:11px; ">SHIPMENT</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createShipment.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchShipment.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>
          <center><div style="width:100%; height:20px; background:#CECAC6;"><span style=" color:#630000; font-weight:600; font-size:14px;">JOB ORDERS</span></div></center>

          <li id="chinaorders_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">CHINA Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createJobOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchJobOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          
          <li id="usaorders_list" class="treeview" style="border-bottom:1px solid gray; padding:5px; margin-top:0px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">USA Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createUsaOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchUsaOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          
          <li id="latamorders_list" class="treeview" style="border-bottom:1px solid gray; padding:5px; margin-top:0px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">LATAM Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createLATAMOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchLATAMOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          
          <li id="taiwanorders_list" class="treeview" style="border-bottom:1px solid gray; padding:5px; margin-top:0px;">
            <a href="#" style="height:25px; position:relative; top:-10px;">
              <i class="fa fa-files-o"></i> <span style="font-size:11px;">TAIWAN Orders</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a  id="create" href="createTAIWANOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a  id="search" href="searchTAIWANOrder.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>

          <center><div style="width:100%; height:20px;background:#CECAC6;"><span style="width:100%; color:#630000; font-weight:600; font-size:14px;">SUPPORT AREA</span></div></center>
          <li id="tickets_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;"> 
              <i class="fa fa-info"></i> <span style="font-size:11px;">Tickets</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createTicket.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchTicket.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>
          <?php if(isset($level) && $level=='master'){ ?>
          <center><div style="width:100%; height:20px;background:#CECAC6;"><span style="  color:#630000; font-weight:600; font-size:14px;">USERS SETTINGS</span></div></center>
          <li id="users_list" class="treeview" style="border-bottom:1px solid gray; padding:5px;">
            <a href="#" style="height:25px; position:relative; top:-10px;"> 
              <i class="fa fa-user"></i> <span style="font-size:11px;">Users</span>
              <span class="pull-right-container" style="top:22px;">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a id="create" href="createUsers.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Create</a></li>
              <li><a id="search" href="searchUsers.php" style="font-size:11px;"><i class="fa fa-circle-o"></i>Search</a></li>
            </ul>
          </li>
          <?php } ?>
      </section>
      <!-- /.sidebar -->
    </aside>