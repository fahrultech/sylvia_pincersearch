<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <!-- ========== Left Sidebar Start ========== -->
 <div class="left side-menu">
                <div class="slimscroll-menu" id="remove-scroll">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="<?php echo site_url('ImportData');?>">
                                    <i class="fi-box"></i><span> Import Data </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('DataBarang');?>">
                                    <i class="fi-box"></i><span> Data Barang </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('DataTransaksi');?>">
                                    <i class="fi-air-play"></i><span> Data Transaksi </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('DataDetailTransaksi');?>">
                                    <i class="fi-air-play"></i><span> Data Detail Transaksi </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('PerhitunganPincerSearch');?>"><i class="fi-target"></i> <span> Perhitungan Pincer</span></a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('Profile');?>"><i class="fi-briefcase"></i> <span> Edit Profile </span></a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/logout');?>"><i class="fi-paper"></i> <span> Logout </span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
            </div>
            <!-- Left Sidebar End -->