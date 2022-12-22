 <!--begin::Brand-->
 <div class="brand flex-column-auto" id="kt_brand">
     <!--begin::Logo-->
     <a href="index.html" class="brand-logo">
         {{-- <img alt="Logo" src="{{ asset('media/logos/logo-light.png')}}" /> --}}
         <h2>Aplikasi X</h2>
     </a>
     <!--end::Logo-->
     <!--begin::Toggle-->
     <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
         <span class="svg-icon svg-icon svg-icon-xl">
             <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                 height="24px" viewBox="0 0 24 24" version="1.1">
                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <polygon points="0 0 24 0 24 24 0 24" />
                     <path
                         d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                         fill="#000000" fill-rule="nonzero"
                         transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                     <path
                         d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                         fill="#000000" fill-rule="nonzero" opacity="0.3"
                         transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                 </g>
             </svg>
             <!--end::Svg Icon-->
         </span>
     </button>
     <!--end::Toolbar-->
 </div>
 <!--end::Brand-->

 <!--begin::Aside Menu-->
 <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
     <!--begin::Menu Container-->
     <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">
         <!--begin::Menu Nav-->
         <ul class="menu-nav">
             <li class="menu-item menu-item-{{ request()->is('/*') ? 'active' : '' }}" aria-haspopup="true">
                 <a href="{{ route('/') }}" class="menu-link">
                     <span class="svg-icon menu-icon">
                         <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                 <polygon points="0 0 24 0 24 24 0 24" />
                                 <path
                                     d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                     fill="#000000" fill-rule="nonzero" />
                                 <path
                                     d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                     fill="#000000" opacity="0.3" />
                             </g>
                         </svg>
                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-text">Dashboard</span>
                 </a>
             </li>

             <li class="menu-item menu-item-submenu menu-item-{{ request()->is('invoices*') ? 'active' : '' }}"
                 aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:void(0)" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-clipboard-list"></i>
                     </span>
                     <span class="menu-text">Invoice</span>
                     <i class="menu-arrow"></i>
                 </a>
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                         <li class="menu-item menu-item-parent" aria-haspopup="true">
                             <span class="menu-link">
                                 <span class="menu-text">Invoice</span>
                             </span>
                         </li>

                         <li class="menu-item menu-item-submenu menu-item-{{ request()->is('invoices/unpaid*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('invoices.unpaid.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Invoice Belum Dibayar</span>
                             </a>
                         </li>

                         <li class="menu-item menu-item-submenu menu-item-{{ request()->is('invoices/paid*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('invoices.paid.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Invoice Terbayar</span>
                             </a>
                         </li>

                         <li class="menu-item menu-item-submenu menu-item-{{ request()->is('invoices/cancel*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('invoices.cancel.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Invoice Dibatalkan</span>
                             </a>
                         </li>
                     </ul>
                 </div>
             </li>

             <li class="menu-item menu-item-submenu menu-item-{{ request()->is('orders*') ? 'active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="{{ route('orders.index') }}" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </span>
                    <span class="menu-text">Orders</span>
                </a>
            </li>

             <li class="menu-item menu-item-submenu menu-item-{{ request()->is('members*') ? 'active' : '' }}"
                 aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:void(0)" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-users"></i>
                     </span>
                     <span class="menu-text">Member</span>
                     <i class="menu-arrow"></i>
                 </a>
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                         <li class="menu-item menu-item-parent" aria-haspopup="true">
                             <span class="menu-link">
                                 <span class="menu-text">Member</span>
                             </span>
                         </li>
                         <li class="menu-item menu-item-submenu menu-item-{{ request()->is('members') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('members.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Data Member</span>
                             </a>
                         </li>
                         <li class="menu-item menu-item-submenu menu-item-{{ request()->is('members/blocked*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('members.blocked.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Member Blokir</span>
                             </a>
                         </li>
                         <li class="menu-item menu-item-submenu menu-item-{{ request()->is('members/member_type*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('members.member_type.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text"> Tipe Member</span>
                             </a>
                         </li>

                     </ul>
                 </div>
             </li>


             <li class="menu-item menu-item-submenu menu-item-{{ request()->is('banners') ? 'active' : '' }}"
                 aria-haspopup="true" data-menu-toggle="hover">
                 <a href="javascript:void(0)" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <i class="fas fa-pencil-alt"></i>
                     </span>
                     <span class="menu-text">Konten</span>
                     <i class="menu-arrow"></i>
                 </a>
                 <div class="menu-submenu">
                     <i class="menu-arrow"></i>
                     <ul class="menu-subnav">
                         <li class="menu-item menu-item-parent" aria-haspopup="true">
                             <span class="menu-link">
                                 <span class="menu-text">Konten</span>
                             </span>
                         </li>

                         <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                             <a href="javascript:void(0)" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Banner</span>
                                 <i class="menu-arrow"></i>
                             </a>
                             <div class="menu-submenu">
                                 <i class="menu-arrow"></i>
                                 <ul class="menu-subnav">
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="{{ route('banners.category.index') }}" class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Kategori</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="{{ route('banners.index') }}" class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Data Banner</span>
                                         </a>
                                     </li>
                                 </ul>
                             </div>
                         </li>

                         <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('product_home.index') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Produk Rekomendasi</span>
                             </a>
                         </li>

                         <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('supplier_home.index') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Supplier Rekomendasi</span>
                             </a>
                         </li>


                         <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                             <a href="javascript:void(0)" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Nomor CS</span>
                                 <i class="menu-arrow"></i>
                             </a>
                             <div class="menu-submenu">
                                 <i class="menu-arrow"></i>
                                 <ul class="menu-subnav">
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="{{ route('cs-number.category.index') }}" class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Kategori</span>
                                         </a>
                                     </li>
                                     <li class="menu-item" aria-haspopup="true">
                                         <a href="{{ route('cs-number.index') }}" class="menu-link">
                                             <i class="menu-bullet menu-bullet-dot">
                                                 <span></span>
                                             </i>
                                             <span class="menu-text">Data Nomor CS</span>
                                         </a>
                                     </li>
                                 </ul>
                             </div>
                         </li>
                         <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('markup.index') }}" class="menu-link">
                                 {{-- edit routenyaguys --}}
                                 <i class="menu-bullet menu-bullet-dot">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Markup</span>
                             </a>
                         </li>
                         <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('video_tutorials.index') }}" class="menu-link">
                                {{-- edit routenyaguys --}}
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Video Tutorial</span>
                            </a>
                        </li>

                     </ul>
                 </div>
             </li>

             @role('super_user')
                 <li class="menu-section">
                     <h4 class="menu-text">Data Master</h4>
                     <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                 </li>
                 <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:;" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             <i class="fas fa-users-cog"></i>
                         </span>
                         <span class="menu-text">Manajemen Akses</span>
                         <i class="menu-arrow"></i>
                     </a>
                     <div class="menu-submenu">
                         <i class="menu-arrow"></i>
                         <ul class="menu-subnav">
                             <li class="menu-item menu-item-parent" aria-haspopup="true">
                                 <span class="menu-link">
                                     <span class="menu-text">Manajemen Akses</span>
                                 </span>
                             </li>

                             @can('read_role')
                                 <li class="menu-item" aria-haspopup="true">
                                     <a href="{{ route('users.index') }}" class="menu-link">
                                         <i class="menu-bullet menu-bullet-dot">
                                             <span></span>
                                         </i>
                                         <span class="menu-text">Pengguna</span>
                                     </a>
                                 </li>
                             @endcan

                             @can('read_role')
                                 <li class="menu-item" aria-haspopup="true">
                                     <a href="{{ route('roles.index') }}" class="menu-link">
                                         <i class="menu-bullet menu-bullet-dot">
                                             <span></span>
                                         </i>
                                         <span class="menu-text">Peran</span>
                                     </a>
                                 </li>
                             @endcan

                             @can('read_role')
                                 <li class="menu-item" aria-haspopup="true">
                                     <a href="{{ route('permissions.index') }}" class="menu-link">
                                         <i class="menu-bullet menu-bullet-dot">
                                             <span></span>
                                         </i>
                                         <span class="menu-text">Izin Akses</span>
                                     </a>
                                 </li>
                             @endcan
                         </ul>
                     </div>
                 </li>
             @endrole
         </ul>
     </div>
     <!--end::Menu Container-->
 </div>
 <!--end::Aside Menu-->
