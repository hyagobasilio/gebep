<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        @if(Auth::check())
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $avatarThumb }}" class="img-circle" alt="{{ $userName }}">
            </div>
            <div class="pull-left info">
                <p>{{ $userName  }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ URL::to('admin/users') }}"><i class="fa fa-user"></i> <span>Usuários</span></a></li>
            <li><a href="{{ URL::to('admin/materias') }}"><i class="fa fa-th"></i> <span>Matérias</span></a></li>
            <li><a href="{{ URL::to('admin/turmas') }}"><i class="fa fa-edit"></i><span> Turmas</span></a></li>
            <li><a href="{{ URL::to('admin/faltas') }}"><i class="fa fa-edit"></i><span> Faltas</span></a></li>
            <li class="treeview">
                <a href="#"><span>Relacionar</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ URL::to('admin/alunos-turma') }}">Alunos / Turmas</a></li>
                    <li><a href="{{ URL::to('admin/professor-materias') }}">Professor / Matérias</a></li>
                    <li><a href="{{ URL::to('admin/materias-turma') }}">Matérias / Turmas</a></li>
                    <li><a href="{{ URL::to('admin/professor-turmas') }}">Professor / Turmas</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
        @endif
    </section>
    <!-- /.sidebar -->
</aside>