<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/backend/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="/backend/bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="/backend/bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="/backend/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="/backend/dist/css/skins/skin-blue.min.css">

  <link rel="stylesheet" href="/backend/css/alertify.min.css">

  <link rel="stylesheet" href="/backend/css/default.min.css">

  <link rel="stylesheet" href="/backend/css/chosen.min.css">

  <link rel="stylesheet" href="/backend/css/select2.min.css">

  <link rel="stylesheet" href="/backend/css/jquery-ui.css">
  @yield('css')
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <a href="" class="logo">
      <span class="logo-mini"><b>Q</b>M</span>
      <span class="logo-lg"><b>LiSANS</b>YAZILIMI</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/{{session()->get('image')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{session()->get('displayName')}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="/{{session()->get('image')}}" class="img-circle" alt="User Image">
                <p>
                  {{session()->get('displayName')}}
                  <small>Samsun Büyükşehir Belediyesi</small>
                </p>
              </li>
              <li class="user-body">
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('admin.profil')}}" class="btn btn-default btn-flat">Profil</a>
                </div>
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat">Oturumu Kapat</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/{{session()->get('image')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{session()->get('displayName')}}</p>
          <a href="{{route('dashboard')}}"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">BAŞLIKLAR</li>
        <li class="active"><a href="{{route('dashboard')}}"><i class="fa fa-link"></i> <span>Ana Ekran</span></a></li>
        <li class="treeview">
          <a href="javascript:void()"><i class="fa fa-link"></i> <span>Lisans</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('licence.getallbylimit')}}">Lisans Listesi</a></li>
          </ul>
        </li>

        <li class="treeview">
            <a href="javascript:void()"><i class="fa fa-link"></i> <span>Kategori</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{route('mainCategory.getall')}}">Kategori Listesi</a></li>
                <li><a href="{{route('customCategory.getall')}}">Özel Kategori Listesi</a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="javascript:void();"><i class="fa fa-link"></i> <span>Yönetici</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{route('admin.getall')}}">Yönetici Listesi</a></li>
            </ul>
        </li>

      </ul>
    </section>
  </aside>

  <div class="content-wrapper">

    @yield('content')
    <section class="content container-fluid">

    </section>
  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Samsun Bilgi İşlem Daire Başkanlığı
    </div>
    <strong>Kopyalanamaz &copy; 2025 </strong> Tüm Hakları Saklıdır
  </footer>

  <div class="control-sidebar-bg"></div>
</div>

  <script src="/backend/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="/backend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/backend/dist/js/adminlte.min.js"></script>
  <!-- Alertify Js -->
  <script src="/backend/js/alertify.min.js"></script>
  <!--Chosen JS -->
  <script src="/backend/js/chosen.min.js"></script>
  <!--Select2 JS -->
  <script src="/backend/js/select2.min.js"></script>

  <script src="/backend/js/jquery-ui.min.css"></script>
  @yield('js')
</body>
</html>
