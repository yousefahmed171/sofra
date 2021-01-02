@inject('setting', 'App\Models\Setting')

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('admin/home')}}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->


      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
    </ul>

    <!-- logout-->
    <li class="nav-item d-none d-sm-inline-block">
      <a class="btn btn-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
    </li>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('admin/home')}}" class="brand-link">
      <img src="{{asset('admin/img/sofra.jpg')}}"
           alt="Sofra Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sofra Admin </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">  {{auth()->guard('admin')->user()->name}} </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Sections
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('categories.index')}}" class="nav-link">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Category
              </p>
            </a>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-flag"></i>
              <p>
                Cities
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('cities.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-city"></i>
                  <p>Show Cities</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('cities.create')}}" class="nav-link">
                  <i class="nav-icon fas fa-file-signature"></i>
                  <p>Create Cities </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-city"></i>
              <p>
                Regions
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('regions.index')}}" class="nav-link">
                  <i class="nav-icon fas fa-city"></i>
                  <p>Show Regions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('regions.create')}}" class="nav-link">
                  <i class="nav-icon fas fa-file-signature"></i>
                  <p>Create Regions </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('clients.index')}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clients
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('restaurants.index')}}" class="nav-link">
              <i class="nav-icon fas fa-pizza-slice"></i>
              <p>
                Restaurants
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('offers.index')}}" class="nav-link">
              <i class="nav-icon fas fa-gift"></i>
              <p>
                Offers
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('orders.index')}}" class="nav-link">
              <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Orders
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('contacts.index')}}" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Payment Method
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('contacts.index')}}" class="nav-link">
              <i class="nav-icon fas fa-phone-alt"></i>
              <p>
                Contacts
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('reset-password.edit', auth()->guard('admin')->user()->id)}}
              " class="nav-link">
              <i class="nav-icon fa fa-key"></i>
              <p>
                Reset Password
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('admins.index')}}" class="nav-link">
              
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Admin
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="{{route('roles.index')}}" class="nav-link">
              
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Role Admin 
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            @foreach ($setting->all() as $item)
            <a href="{{route('settings.edit', $item->id)}}" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
            @endforeach
              <p>
                Settings
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
