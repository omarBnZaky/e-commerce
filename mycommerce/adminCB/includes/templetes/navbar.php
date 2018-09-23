<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="dasbord.php"><?php echo lang('HOME_ADMIN') ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
       <li class="nav-item "><a class="nav-link" href="categories.php"><?php echo lang('CAT_ADMIN')  ?></a></li>
       <li class="nav-item "><a class="nav-link" href="Items.php"><?php echo lang('ITEMS')      ?></a></li>
       <li class="nav-item "><a class="nav-link" href="members.php"><?php echo lang('MEMBERS')    ?></a></li>
        <li class="nav-item "><a class="nav-link" href="comments.php"><?php echo lang('COMMENTS')    ?></a></li>
       <li class="nav-item "><a class="nav-link" href="#"><?php echo lang('STATISTICS') ?></a></li>
       <li class="nav-item "><a class="nav-link" href="#"><?php echo lang('LOGS')       ?></a></li>


   
      

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         Omar
        </a>
        <div class="dropdown-menu"  aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit profile</a>
          <a class="dropdown-item" href="../index.php">Visit shop</a>
          <a class="dropdown-item" href="#">settings</a>
          <a class="dropdown-item" href="logout.php">logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
