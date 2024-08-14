<?php


function sistema_menu($modulo,$interfaz,$origen) 
        {    
          $mysqli      = conexionMySQL();
          $Global      = new ModelGlobal();
          $sql         = "SELECT * FROM  gb_modulo WHERE gb_estatus='1' ORDER BY gb_id_modulo  ASC";
          $resultado   = $mysqli->query($sql);
          while ($fila = $resultado->fetch_assoc()) 
          {
           
           
            /** PERFIL ADMINISTRADOR **/
            if ($_SESSION["gb_perfil"]== 1) 
            {

              if($modulo == 0)
              {  
        ?>  
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="<?php echo  $fila['gb_icono_modulo']; ?>"></i>
                  <p>
                  <?php echo  $fila['gb_nombre_modulo']; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>

        <?php
              }
              else
              {

                if($modulo == $fila['gb_id_modulo'])
                { 

        ?>    

            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                  <i class="<?php echo  $fila['gb_icono_modulo']; ?>"></i>
                  <p>
                  <?php echo  $fila['gb_nombre_modulo']; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>


                <?php
              }
              else
              {
             ?>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="<?php echo  $fila['gb_icono_modulo']; ?>"></i>
                  <p>
                  <?php echo  $fila['gb_nombre_modulo']; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                
        <?php
                }
              }

              ?> 
            <!-- CARGAMOS EL MENU -->
            <ul class="nav nav-treeview">

            <?php
               

               $sql_menu         = "SELECT * FROM  gb_menu WHERE gb_id_modulo  ='".$fila['gb_id_modulo']."' AND gb_estatus='1'";
               $resultado_menu   = $mysqli->query($sql_menu);
               while ($fila_menu = $resultado_menu->fetch_assoc()) 
               {

                if($origen == 0)
                {
                    
                    $ext = $fila_menu['gb_raiz'].'/';
                }
                else
                {
                    $ext = '';
                }

                if($interfaz == $fila_menu['gb_id_menu'])
                { 
             ?>

              <li class="nav-item">

              <a href="./?opc=<?php echo  $ext.$fila_menu['gb_archivo']; ?>" class="nav-link active">
              <i class="far fa-dot-circle nav-icon"></i>
                  <p><?php echo  $fila_menu['gb_nombre_menu']; ?></p>
                </a>
              </li>

              <?php
                }
                else
               {

               
            ?>

              <li class="nav-item">
                <a href="<?php echo  $ext; ?>./?opc=<?php echo  $fila_menu['gb_archivo']; ?>" class="nav-link">
                <i class="far fa-dot-circle nav-icon"></i>
                  <p><?php echo  $fila_menu['gb_nombre_menu']; ?></p>
                </a>
              </li>
            
            <?php
               }
               }
            ?>
            </ul>

          <?php    
          } 
          /** NO ES PERFIL ADMINISTRADOR **/
          else 
          {
            if($_SESSION["gb_id_user"] == 24)
            {
               // $validacion = 1 == 1;
                if($fila['gb_id_modulo'] == 3)
                {
                  $validacion = 1 != 1;
                }
                else
                {
                  $validacion = 1 == 1;
                }
            }
            else
            {
              
              if($_SESSION["gb_id_user"] == 274)
              {
                  if($fila['gb_id_modulo'] ==5)
                  {
                    $validacion = 1==1;
                  }
                  else
                  {
                    $validacion = $Global->modulo_permitido($fila['gb_id_modulo'], $_SESSION["gb_perfil"]) == 1;
                  }
                  
              }
              else
              {
                $validacion = $Global->modulo_permitido($fila['gb_id_modulo'], $_SESSION["gb_perfil"]) == 1;
              }
              
              
             
            }


             if($validacion)
            {
        ?> 

    <?php
    if($modulo == 0)
                  {  
            ?>  
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="<?php echo  $fila['gb_icono_modulo']; ?>"></i>
                  <p>
                  <?php echo  $fila['gb_nombre_modulo']; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>

        <?php
              }
              else
              {

                if($modulo == $fila['gb_id_modulo'])
                { 

        ?>    

            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                  <i class="<?php echo  $fila['gb_icono_modulo']; ?>"></i>
                  <p>
                  <?php echo  $fila['gb_nombre_modulo']; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>


                <?php
              }
              else
              {
             ?>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="<?php echo  $fila['gb_icono_modulo']; ?>"></i>
                  <p>
                  <?php echo  $fila['gb_nombre_modulo']; ?>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                
        <?php
                }
              }

              ?> 
            <!-- CARGAMOS EL MENU -->
            <ul class="nav nav-treeview">
            <?php
               

               $sql_menu         = "SELECT * FROM  gb_menu WHERE gb_id_modulo  ='".$fila['gb_id_modulo']."' AND gb_estatus='1'";
			   
               $resultado_menu   = $mysqli->query($sql_menu);
               while ($fila_menu = $resultado_menu->fetch_assoc()) 
               {

                if($origen == 0)
                {
                    
                    $ext = $fila_menu['gb_raiz'].'/';
                }
                else
                {
                    $ext = '';
                }


              

                if ($_SESSION["gb_perfil"]== 4) 
                {

                  if ($fila_menu['gb_id_menu']== '15') 
                {
                  ?>



             
             <?php 
              }
              else
              {
              ?>


<li class="nav-item">
                  <a href="<?php echo  $ext; ?>./?opc=<?php echo  $fila_menu['gb_archivo']; ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                    <p><?php echo  $fila_menu['gb_nombre_menu']; ?></p>
                  </a>
                </li>

              <?php
              }
                } else {
                  
                ?>

                

                <li class="nav-item">
                  <a href="<?php echo  $ext; ?>./?opc=<?php echo  $fila_menu['gb_archivo']; ?>" class="nav-link">
                  <i class="far fa-dot-circle nav-icon"></i>
                    <p><?php echo  $fila_menu['gb_nombre_menu']; ?></p>
                  </a>
                </li>
              
              <?php
                }


               }
            ?>
            </ul>


        <?php
              }
            }
          }
        }
        ?>