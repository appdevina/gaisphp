<nav class="navbar navbar-default navbar-fixed-top">
	<div class="brand">
		<a href="/dashboard"><img src="{{asset('admin/assets/img/logo-dark.png')}}" alt="Klorofil Logo" class="img-responsive logo"></a>
	</div>
	<div class="container-fluid">
		<div class="navbar-btn">
			<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
		</div>
		<form class="navbar-form navbar-left" method="GET" action="/category">
		</form>
		<div id="navbar-menu">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{auth()->user()->getProfilePic()}}" class="img-circle" alt="Avatar"> <span>{{auth()->user()->fullname}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
					<ul class="dropdown-menu">
						<li><a href="/logout"><i class="lnr lnr-exit"></i> <span>KELUAR</span></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>