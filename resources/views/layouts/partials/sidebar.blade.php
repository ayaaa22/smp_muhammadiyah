<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="#" style="display: flex; align-items: center; padding: 10px; text-decoration: none;">
                        <img src="{{ asset('assets/static/images/logo/logo-smp.jpeg') }}" alt="Logo"
                            style="height: 70px; width: auto; margin-right: 10px;">

                        <div
                            style="font-size: 13px; font-weight: bold; color: #000; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <b>SMP MUHAMMADIYAH 4
                                <br>PURWOHARJO</b>
                        </div>
                    </a>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label" for="toggle-dark"></label>
                    </div>

                </div>

                <!-- Sidebar Close Button -->
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Home Menu</li>
                @auth
                    @php
                        $role = auth()->user()->role;
                        $isActiveMaster =
                            request()->routeIs('jabatan.index') ||
                            request()->routeIs('pegawai.index') ||
                            request()->routeIs('jenis-cuti.index');
                    @endphp

                    @if ($role === 'admin')
                        <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <a href="{{ url('/admin/dashboard') }}" class="sidebar-link">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('presensi.index') ? 'active' : '' }}">
                            <a href="{{route('presensi.index')}}" class="sidebar-link">
                                <i class="bi bi-person-check"></i>
                                <span>Presensi</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('kehadiran.index') ? 'active' : '' }}">
                            <a href="{{route('kehadiran.index')}}" class="sidebar-link">
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Rekap Kehadiran</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Main Menu</li>
                        <li class="sidebar-item has-sub {{ $isActiveMaster ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-database"></i>
                                <span>Master Data</span>
                            </a>
                            <ul class="submenu {{ $isActiveMaster ? 'd-block' : '' }}">
                                <li class="submenu-item {{ request()->routeIs('jabatan.index') ? 'active' : '' }}">
                                    <a href="{{ route('jabatan.index') }}">
                                        <i class="bi bi-circle"></i>
                                        Jabatan</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('pegawai.index') ? 'active' : '' }}">
                                    <a href="{{ route('pegawai.index') }}">
                                        <i class="bi bi-circle"></i>
                                        Pegawai</a>
                                </li>
                                <li class="submenu-item {{ request()->routeIs('jenis-cuti.index') ? 'active' : '' }}">
                                    <a href="{{ route('jenis-cuti.index') }}">
                                        <i class="bi bi-circle"></i>
                                        Jenis Cuti</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('cuti.admin.index') ? 'active' : '' }}">
                            <a href="{{route('cuti.admin.index')}}" class="sidebar-link">
                                <i class="bi bi-calendar2-plus"></i>
                                <span>Pengajuan Cuti</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('#.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-suitcase-lg"></i>
                                <span>Surat Tugas</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Pengaturan</li>
                        <li class="sidebar-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="sidebar-link">
                                <i class="bi bi-people"></i>
                                <span>Manajemen Pengguna</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('waktu.index') ? 'active' : '' }}">
                            <a href="{{route('waktu.index')}}" class="sidebar-link">
                                <i class="bi bi-gear"></i>
                                <span>Pengaturan Waktu</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('#.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-info-circle"></i>
                                <span>Tentang Aplikasi</span>
                            </a>
                        </li>
                    @elseif($role === 'pegawai')
                        <li class="sidebar-item {{ request()->is('pegawai/dashboard') ? 'active' : '' }}">
                            <a href="{{ url('/pegawai/dashboard') }}" class="sidebar-link">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Main Menu</li>
                        <li class="sidebar-item {{ request()->routeIs('pegawai_presensi.index') ? 'active' : '' }}">
                            <a href="{{route('pegawai_presensi.index')}}" class="sidebar-link">
                                <i class="bi bi-person-check"></i>
                                <span>Presensi</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('cuti.pegawai.index') ? 'active' : '' }}">
                            <a href="{{route('cuti.pegawai.index')}}" class="sidebar-link">
                                <i class="bi bi-calendar2-plus"></i>
                                <span>Pengajuan Cuti</span>
                            </a>
                        </li>
                    @elseif($role === 'kepsek')
                        <li class="sidebar-item {{ request()->is('kepsek/dashboard') ? 'active' : '' }}">
                            <a href="{{ url('/kepsek/dashboard') }}" class="sidebar-link">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('#.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-person-check"></i>
                                <span>Presensi</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Main Menu</li>
                        <li class="sidebar-item {{ request()->routeIs('kepsek-pegawai.index') ? 'active' : '' }}">
                            <a href="{{ route('kepsek-pegawai.index') }}" class="sidebar-link">
                                <i class="bi bi-database"></i>
                                <span>Master Data</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('cuti.kepsek.index') ? 'active' : '' }}">
                            <a href="{{route('cuti.kepsek.index')}}" class="sidebar-link">
                                <i class="bi bi-calendar2-plus"></i>
                                <span>Pengajuan Cuti</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-suitcase-lg"></i>
                                <span>Surat Tugas</span>
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>
        </div>

    </div>
</div>
