

<div style="padding:10px;margin-top:50px" >
    <ul a>
      <!-- <li><a class="active">Bienvenido <?php echo $user?></a></li> -->
      <li style="float:right"><a href="close.php">Salir</a></li>
    </ul>
  </div> 
  <style>
    body {margin:100;}
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
      position: fixed;
      top: 0;
      width: 100%;
    }

    li {
      float: left;
    }

    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    li a:hover:not(.active) {
      background-color: #111;
    }

    .active {
      background-color: #1d138c;
    }
  </style>


