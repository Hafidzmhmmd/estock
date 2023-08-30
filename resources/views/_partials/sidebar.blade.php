@php use App\Helpers\MenuBuilder; @endphp


<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <i class="fa fa-ravelry" aria-hidden="true"></i> {{ config('app.name')}}
        <button type="button" class="btn-toggle-offcanvas btn btn-sm btn-default float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
    </div>
    <div class="sidebar-scroll">
        <nav id="left-sidebar-nav" class="sidebar-nav mt-3">
            <ul id="main-menu" class="metismenu">
                <li class="active"><a href="index.html"><i class="icon-home"></i><span>Dashboard</span></a></li>
                <li><a href="#uiElements" class="has-arrow"><i class="icon-energy"></i><span>Pengajuan</span></a>
                    <ul>
                        <li><a href="ui-card.html">Pembelian Baru</a></li>
                    </ul>
                </li>
                <li><a href="app-inbox.html"><i class="icon-grid"></i><span>Gudang</span></a></li>
                <li><a href="#uiElements" class="has-arrow"><i class="icon-folder-alt"></i><span>Laporan</span></a>
                    <ul>
                        <li><a href="ui-card.html">Pembelian</a></li>
                        <li><a href="ui-card.html">Opname Stock</a></li>
                    </ul>
                </li>
                <li><a href="#uiElements" class="has-arrow"><i class="icon-settings"></i><span>Pengaturan</span></a>
                    <ul>
                        <li><a href="ui-card.html">Pembelian</a></li>
                        <li><a href="ui-card.html">Opname Stock</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
