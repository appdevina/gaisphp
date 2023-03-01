<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<br>
				<li id="dashboard"><a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>BERANDA</span></a></li>
				<li id="request"><a href="/request" class="{{ Request::is('request') ? 'active' : '' }}"><i class="lnr lnr-cart"></i> 
				<span>PENGAJUAN 
					<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->role_id == 2 ? $notifRequestAcc : (auth()->user()->role_id == 4 ? $notifRequestUser : $notifRequestAdmin ) }}</span>
				</span></a></li>
				@if (auth()->user()->role_id == 1 || auth()->user()->role_id >= 3 )
				<li id="problemReport"><a href="/problemReport" class="{{ Request::is('problemReport') ? 'active' : '' }}"><i class="lnr lnr-bubble"></i> 
				<span>LAPOR GANGGUAN
					<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->role_id == 1 ? $notifReportAdmin : (auth()->user()->role_id == 3 ? $notifReportAdmin : $notifReportUser) }}</span>
				</span></a></li>
				@endif
                @if (auth()->user()->role_id == 1)
				<li>
					<a href="#subPagesMaster" data-toggle="collapse" class="collapsed"><i class="lnr lnr-list"></i> <span>DATA</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPagesMaster" class="collapse ">
						<ul class="nav">
							<li><a href="/product" class="{{ Request::is('product') ? 'active' : '' }}"><i class="lnr lnr-inbox"></i>BARANG</a></li>
                            <li><a href="/category" class="{{ Request::is('category') ? 'active' : '' }}"><i class="lnr lnr-inbox"></i>KATEGORI</a></li>
                            <li><a href="/unittype" class="{{ Request::is('unittype') ? 'active' : '' }}"><i class="lnr lnr-inbox"></i>TIPE UNIT</a></li>
							<li><a href="/requesttype" class="{{ Request::is('requesttype') ? 'active' : '' }}"><i class="lnr lnr-bubble"></i>TIPE PENGAJUAN</a></li>
							<li><a href="/prcategory" class="{{ Request::is('prcategory') ? 'active' : '' }}"><i class="lnr lnr-bubble"></i>JENIS GANGGUAN</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href="#subPagesSettings" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>PENGATURAN</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPagesSettings" class="collapse ">
						<ul class="nav">
							<li><a href="/user" class="{{ Request::is('user') ? 'active' : '' }}"><i class="lnr lnr-user"></i>USER</a></li>
                        	<li><a href="/role" class="{{ Request::is('role') ? 'active' : '' }}"><i class="lnr lnr-users"></i>ROLE</a></li>
							<li><a href="/area" class="{{ Request::is('area') ? 'active' : '' }}"><i class="lnr lnr-apartment"></i>AREA</a></li>
							<li><a href="/bu" class="{{ Request::is('bu') ? 'active' : '' }}"><i class="lnr lnr-apartment"></i>BADAN USAHA</a></li>
							<li><a href="/division" class="{{ Request::is('division') ? 'active' : '' }}"><i class="lnr lnr-apartment"></i>DIVISI</a></li>
						</ul>
					</div>
				</li>
				@endif
			</ul>
		</nav>
	</div>
</div>