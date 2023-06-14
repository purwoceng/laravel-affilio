 <!--begin::Brand-->
 <div class="brand flex-column-auto" id="kt_brand">
     <!--begin::Logo-->
     <a href="/" class="login-logo pb-lg-0 pb-5">
         <img alt="Logo" class="img-fluid max-h-50px" src="{{ asset('static/brands/logo-2.png') }}" />
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




             <li class="menu-item menu-item-submenu menu-item-{{ request()->is('orders*') ? 'active' : '' }}"
                 aria-haspopup="true" data-menu-toggle="hover">
                 <a href="{{ route('orders.index') }}" class="menu-link menu-toggle">
                     <span class="svg-icon menu-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-cart-fill" viewBox="0 0 18 18">
                             <path
                                 d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                         </svg>
                     </span>
                     <span class="menu-text">Orders</span>
                 </a>
             </li>

             @hasanyrole('supplier|super_user|admin_member')
                 <li class="menu-item menu-item-submenu {{ request()->is('products*') ? 'menu-item-open' : '' }}"
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:void(0)" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-box2-fill" viewBox="0 0 19 19">
                                 <path
                                     d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4h-8.5ZM15 4.667V5H1v-.333L1.5 4h6V1h1v3h6l.5.667Z" />
                             </svg>
                         </span>
                         <span class="menu-text">Produk</span>
                         <i class="menu-arrow"></i>
                     </a>
                     <div class="menu-submenu">
                         <i class="menu-arrow"></i>
                         <ul class="menu-subnav">
                             {{-- <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('product_list.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Daftar Produk</span>
                            </a>
                        </li> --}}
                             {{-- <li class="menu-item menu-item-submenu menu-item-{{ request()->is('products/inactive*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('products.inactive.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Produk Nonaktif</span>
                             </a>
                         </li> --}}

                             <li class="menu-item menu-item-submenu menu-item-{{ request()->is('products/wishlist*') ? 'active' : '' }}"
                                 aria-haspopup="true" data-menu-toggle="hover">
                                 <a href="{{ route('products.wishlists.index') }}" class="menu-link menu-toggle">
                                     <i class="menu-bullet menu-bullet-line">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Produk Wishlist</span>
                                 </a>
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
                                 <a href="{{ route('recommendation_affilio.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Produk Rekomendasi Affilio</span>
                                 </a>
                             </li>

                         </ul>
                     </div>
                 </li>
             @endhasanyrole

             @hasanyrole('supplier|super_user|admin_member')
                 <li class="menu-item menu-item-submenu
                 {{-- {{ request()->is('suppliers*') ? 'menu-item-open' : '' }} --}}
                 "
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:void(0)" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             {{-- <i class="fas fa-address-book"></i> --}}
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-tags-fill" viewBox="0 0 17 17">
                                 <path
                                     d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                 <path
                                     d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z" />
                             </svg>
                         </span>
                         <span class="menu-text">Markup</span>
                         <i class="menu-arrow"></i>
                     </a>
                     <div class="menu-submenu">
                         <i class="menu-arrow"></i>
                         <ul class="menu-subnav">
                             <li class="menu-item menu-item-parent" aria-haspopup="true">
                                 <span class="menu-link">
                                     <span class="menu-text">Markup</span>
                                 </span>
                             </li>
                             {{-- <li class="menu-item menu-item-submenu menu-item-{{ request()->is('supplierslist') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('supplierslist.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Daftar Supplier </span>
                             </a>
                         </li> --}}
                             {{-- <li class="menu-item menu-item-submenu menu-item-{{ request()->is('suppliers') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('suppliers.nonactive.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Supplier Non Active </span>
                             </a>
                         </li> --}}

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('markup.edit') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Markup Global</span>
                                 </a>
                             </li>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('markup_product.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Markup Produk Satuan</span>
                                 </a>
                             </li>
                         </ul>
                     </div>
                 </li>
             @endhasanyrole

             @hasanyrole('akutansi|super_user|event|admin_member')
                 <li class="menu-item menu-item-submenu {{ request()->is('members*') ? 'menu-item-open' : '' }}"
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:void(0)" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             {{-- <i class="fas fa-users"></i> --}}
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                 <path
                                     d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                             </svg>
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

                             {{-- <li class="menu-item menu-item-submenu menu-item-{{ request()->is('members/accounts*') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                             <a href="{{ route('members.accounts.index') }}" class="menu-link menu-toggle">
                                 <i class="menu-bullet menu-bullet-line">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Verifikasi Rekening</span>
                             </a>
                         </li> --}}


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
             @endhasanyrole



             @hasanyrole('konten|super_user|admin_member')
                 <li class="menu-item menu-item-submenu {{ request()->is('banners*') ? 'menu-item-open' : '' }}"
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:void(0)" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             {{-- <i class="fas fa-pencil-alt"></i> --}}
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil-fill" viewBox="0 0 18 18">
                                 <path
                                     d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                             </svg>
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

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('banners.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Banner</span>
                                 </a>
                             </li>



                             {{-- <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('supplier_home.index') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Supplier Rekomendasi</span>
                             </a>
                         </li> --}}


                             <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                 {{-- <a href="javascript:void(0)" class="menu-link menu-toggle">
                                     <i class="menu-bullet menu-bullet-line">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Nomor CS</span>
                                     <i class="menu-arrow"></i>
                                 </a> --}}
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
                                         {{-- <li class="menu-item" aria-haspopup="true">
                                             <a href="{{ route('cs-number.index') }}" class="menu-link">
                                                 <i class="menu-bullet menu-bullet-dot">
                                                     <span></span>
                                                 </i>
                                                 <span class="menu-text">Data Nomor CS</span>
                                             </a>
                                         </li> --}}
                                     </ul>
                                 </div>
                             </li>
                             {{-- <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('video_tutorials.index') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Video Tutorials</span>
                             </a>
                         </li> --}}
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('video_training.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Video Training</span>
                                 </a>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('categories.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Kategori</span>
                                 </a>
                             </li>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('supplierscover.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Cover Supplier</span>
                                 </a>
                             </li>
                             {{-- <li class="menu-item menu-item-submenu menu-item-{{ request()->is('supplierscover') ? 'active' : '' }}"
                             aria-haspopup="true" data-menu-toggle="hover">
                                 <a href="{{ route('supplierscover.index') }}" class="menu-link menu-toggle">
                                     <i class="menu-bullet menu-bullet-line">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Cover Supplier</span>
                                 </a>
                             </li> --}}
                         </ul>
                     </div>
                 </li>

                 {{-- start --}}

                 <li class="menu-item menu-item-submenu menu-item-{{ request()->is('funnel*') ? 'active' : '' }}"
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="{{ route('funnel.index') }}" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-house-gear-fill" viewBox="0 0 17 17">
                                 <path
                                     d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5Z" />
                                 <path
                                     d="M11.07 9.047a1.5 1.5 0 0 0-1.742.26l-.02.021a1.5 1.5 0 0 0-.261 1.742 1.5 1.5 0 0 0 0 2.86 1.504 1.504 0 0 0-.12 1.07H3.5A1.5 1.5 0 0 1 2 13.5V9.293l6-6 4.724 4.724a1.5 1.5 0 0 0-1.654 1.03Z" />
                                 <path
                                     d="m13.158 9.608-.043-.148c-.181-.613-1.049-.613-1.23 0l-.043.148a.64.64 0 0 1-.921.382l-.136-.074c-.561-.306-1.175.308-.87.869l.075.136a.64.64 0 0 1-.382.92l-.148.045c-.613.18-.613 1.048 0 1.229l.148.043a.64.64 0 0 1 .382.921l-.074.136c-.306.561.308 1.175.869.87l.136-.075a.64.64 0 0 1 .92.382l.045.149c.18.612 1.048.612 1.229 0l.043-.15a.64.64 0 0 1 .921-.38l.136.074c.561.305 1.175-.309.87-.87l-.075-.136a.64.64 0 0 1 .382-.92l.149-.044c.612-.181.612-1.049 0-1.23l-.15-.043a.64.64 0 0 1-.38-.921l.074-.136c.305-.561-.309-1.175-.87-.87l-.136.075a.64.64 0 0 1-.92-.382ZM12.5 14a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z" />
                             </svg>
                         </span>
                         <span class="menu-text">Funnel</span>
                         <i class="menu-arrow"></i>
                     </a>
                     <div class="menu-submenu">
                         <i class="menu-arrow"></i>
                         <ul class="menu-subnav">
                             <li class="menu-item menu-item-parent" aria-haspopup="true">
                                 <span class="menu-link">
                                     <span class="menu-text">Funnel</span>
                                 </span>
                             </li>

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('funnel.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Funnel Home</span>
                                 </a>
                             </li>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('notification.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Notification</span>
                                 </a>
                             </li>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('headerfunnel.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Header</span>
                                 </a>
                             </li>

                         </ul>
                     </div>
                 </li>
             @endhasanyrole




             {{-- end --}}
             @hasanyrole('admin_member|super_user|event')
                 <li class="menu-item menu-item-submenu menu-item-
                    {{ request()->is('event*') ? 'menu-item-open' : '' }}"
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="{{ route('event.index') }}" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                 class="bi bi-calendar2-event" viewBox="0 0 20 20">
                                 <path
                                     d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                 <path
                                     d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                 <path
                                     d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
                             </svg>
                         </span>
                         <span class="menu-text">Event</span>
                         <i class="menu-arrow"></i>
                     </a>
                     <div class="menu-submenu">
                         <i class="menu-arrow"></i>
                         <ul class="menu-subnav">
                             <li class="menu-item menu-item-parent" aria-haspopup="true">
                                 <span class="menu-link">
                                     <span class="menu-text">Event</span>
                                 </span>
                             </li>

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('event.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Event</span>
                                 </a>
                             </li>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('greeting.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Greeting</span>
                                 </a>
                             </li>
                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('tiket.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Tiket</span>
                                 </a>
                             </li>

                         </ul>
                     </div>
                 </li>
             @endhasanyrole
             @hasanyrole('akutansi|super_user')
                 <li class="menu-item menu-item-submenu {{ request()->is('dana*') ? 'menu-item-open' : '' }}"
                     aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:void(0)" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                 class="bi bi-wallet2" viewBox="0 0 18 18">
                                 <path
                                     d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                             </svg>
                         </span>
                         <span class="menu-text">Dana</span>
                         <i class="menu-arrow"></i>
                     </a>
                     <div class="menu-submenu">
                         <i class="menu-arrow"></i>
                         <ul class="menu-subnav">
                             <li class="menu-item menu-item-parent" aria-haspopup="true">
                                 <span class="menu-link">
                                     <span class="menu-text">Dana</span>
                                 </span>
                             </li>

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('eventfund.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Acara</span>
                                 </a>
                             </li>

                             {{-- <li class="menu-item" aria-haspopup="true">
                             <a href="{{ route('reward.index') }}" class="menu-link">
                                 <i class="menu-bullet menu-bullet-dot">
                                     <span></span>
                                 </i>
                                 <span class="menu-text">Reward</span>
                             </a>
                         </li> --}}

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('pensiun.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Pensiun</span>
                                 </a>
                             </li>

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('fund.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Riwayat</span>
                                 </a>
                             </li>

                             <li class="menu-item" aria-haspopup="true">
                                 <a href="{{ route('withdraw.index') }}" class="menu-link">
                                     <i class="menu-bullet menu-bullet-dot">
                                         <span></span>
                                     </i>
                                     <span class="menu-text">Penarikan</span>
                                 </a>
                             </li>

                         </ul>
                     </div>
                 </li>
             @endhasanyrole

             @role('super_user')
                 <li class="menu-section">
                     <h4 class="menu-text">Data Master</h4>
                     <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                 </li>
                 <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                     <a href="javascript:;" class="menu-link menu-toggle">
                         <span class="svg-icon menu-icon">
                             {{-- <i class="fas fa-users-cog"></i> --}}
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-person-fill-gear" viewBox="0 0 18 18">
                                 <path
                                     d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                             </svg>
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
