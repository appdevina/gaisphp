<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="/dashboard" class="active"><i class="lnr lnr-home"></i> <span>BERANDA</span></a></li>
				<li><a href="/request" class=""><i class="lnr lnr-cart"></i> <span>PENGAJUAN</span></a></li>
				@if (auth()->user()->role_id == 1 || auth()->user()->role_id >= 3 )
				<li><a href="/problemReport" class=""><i class="lnr lnr-bubble"></i> <span>LAPOR GANGGUAN</span></a></li>
				@endif
                @if (auth()->user()->role_id == 1)
				<li>
					<a href="#subPagesMaster" data-toggle="collapse" class="collapsed"><i class="lnr lnr-list"></i> <span>DATA</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPagesMaster" class="collapse ">
						<ul class="nav">
							<li><a href="/product" class=""><i class="lnr lnr-inbox"></i>BARANG</a></li>
                            <li><a href="/category" class=""><i class="lnr lnr-inbox"></i>KATEGORI</a></li>
                            <li><a href="/unittype" class=""><i class="lnr lnr-inbox"></i>TIPE UNIT</a></li>
							<li><a href="/requesttype" class=""><i class="lnr lnr-bubble"></i>TIPE PENGAJUAN</a></li>
							<li><a href="/prcategory" class=""><i class="lnr lnr-bubble"></i>JENIS GANGGUAN</a></li>
						</ul>
					</div>
				</li>
				<li>
					<a href="#subPagesSettings" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>PENGATURAN</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
					<div id="subPagesSettings" class="collapse ">
						<ul class="nav">
							<li><a href="/user" class=""><i class="lnr lnr-user"></i>USER</a></li>
                        	<li><a href="/role" class=""><i class="lnr lnr-users"></i>ROLE</a></li>
							<li><a href="/area" class=""><i class="lnr lnr-apartment"></i>AREA</a></li>
							<li><a href="/bu" class=""><i class="lnr lnr-apartment"></i>BADAN USAHA</a></li>
							<li><a href="/division" class=""><i class="lnr lnr-apartment"></i>DIVISI</a></li>
						</ul>
					</div>
				</li>
				@endif
			</ul>
		</nav>
	</div>
</div>