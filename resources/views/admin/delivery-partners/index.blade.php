@extends('layouts.admin')
@section('header', 'Parceiros de Entrega')
@section('nav.delivery', 'active')
@section('content')
<div class="vstack gap-3">
    <div class="d-flex align-items-center justify-content-between">
        <p class="small text-muted mb-0">{{ $partners->count() }} parceiro(s) registado(s)</p>
        <a href="{{ route('admin.delivery-partners.create') }}" class="btn btn-primary btn-sm">+ Novo parceiro</a>
    </div>

    @if ($partners->isEmpty())
        <div class="card"><div class="card-body p-5 text-center text-muted">
            <p class="small mb-0">Nenhum parceiro registado.</p>
        </div></div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th class="d-none d-sm-table-cell">Cobertura</th>
                            <th class="d-none d-md-table-cell">Contacto</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $p)
                            <tr>
                                <td class="text-muted">{{ $p->position }}</td>
                                <td>
                                    <div class="fw-medium">{{ $p->name }}</div>
                                    @if ($p->description)
                                        <div class="small text-muted text-truncate" style="max-width:20rem;">{{ $p->description }}</div>
                                    @endif
                                </td>
                                <td class="text-muted d-none d-sm-table-cell">{{ $p->coverage_areas ?: '—' }}</td>
                                <td class="d-none d-md-table-cell text-muted">
                                    @if($p->phone) <div>{{ $p->phone }}</div> @endif
                                    @if($p->email) <div>{{ $p->email }}</div> @endif
                                </td>
                                <td>
                                    @if ($p->is_active)
                                        <span class="badge text-bg-success">Activo</span>
                                    @else
                                        <span class="badge text-bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.delivery-partners.edit', $p) }}" class="link-primary text-decoration-none">Editar</a>
                                        <form method="POST" action="{{ route('admin.delivery-partners.toggle', $p) }}" class="d-inline m-0">
                                            @csrf @method('PUT')
                                            <button class="btn btn-link btn-sm p-0 text-muted text-decoration-none">{{ $p->is_active ? 'Desactivar' : 'Activar' }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.delivery-partners.destroy', $p) }}" class="d-inline m-0"
                                              onsubmit="return confirm('Remover este parceiro?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-link btn-sm p-0 text-danger text-decoration-none">Remover</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
