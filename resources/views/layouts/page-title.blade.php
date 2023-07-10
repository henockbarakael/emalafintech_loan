<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>@yield('page')</h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">                                       <i data-feather="home"></i></a></li>
          <li class="breadcrumb-item">@yield('page_1')</li>
          <li class="breadcrumb-item active">@yield('page_2')</li>
        </ol>
      </div>
    </div>
  </div>
</div>