<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="/dashboard" class="active"><i class="lnr lnr-home"></i> <span>DASHBOARD</span></a></li>
				<li><a href="#" class=""><i class="lnr lnr-cart"></i> <span>REQUEST</span></a></li>
                @if (auth()->user()->role_id == 1)
				<li>
					<a href="#subPagesMaster" data-toggle="collapse" class="collapsed"><i class="lnr lnr-list"></i> <span>MASTER DATA</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPagesMaster" class="collapse ">
						<ul class="nav">
							<li><a href="#" class=""><i class="lnr lnr-inbox"></i>BARANG</a></li>
                            <li><a href="/category" class=""><i class="lnr lnr-inbox"></i>KATEGORI</a></li>
                            <li><a href="#" class=""><i class="lnr lnr-inbox"></i>TIPE UNIT</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href="#subPagesSettings" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>SETTINGS</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPagesSettings" class="collapse ">
						<ul class="nav">
							<li><a href="/user" class=""><i class="lnr lnr-user"></i>USER</a></li>
                        	<li><a href="#" class=""><i class="lnr lnr-users"></i>ROLE</a></li>
							<li><a href="#" class=""><i class="lnr lnr-apartment"></i>AREA</a></li>
							<li><a href="#" class=""><i class="lnr lnr-apartment"></i>BADAN USAHA</a></li>
							<li><a href="#" class=""><i class="lnr lnr-apartment"></i>DIVISI</a></li>
						</ul>
					</div>
				</li>
				@endif
			</ul>
		</nav>
	</div>
</div>