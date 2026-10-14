@extends('layouts.app')

@section('title', 'Minhas inscrições')

@section('content')

<h1 class="h3 mb-2">
    Minhas inscrições
</h1>

<p class="text-muted mb-4">
    Eventos nos quais você realizou uma inscrição.
</p>

<div class="card shadow-sm">
    <div class="card-body">

        @forelse($registrations as $registration)

            @if($loop->first)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Data</th>
                                <th>Local</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
            @endif

                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $registration->event->title }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $registration->event->category->name }}
                                    </small>
                                </td>

                                <td>
                                    {{ $registration->event->start_at->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    {{ $registration->event->location }}
                                </td>

                                <td>
                                    @if($registration->isConfirmed())
                                        <span class="badge text-bg-success">
                                            Confirmada
                                        </span>
                                    @else
                                        <span class="badge text-bg-secondary">
                                            Cancelada
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if(
                                        $registration->isConfirmed()
                                        && !$registration->event->hasStarted()
                                    )
                                        <form
                                            method="POST"
                                            action="{{ route('registrations.destroy', $registration) }}"
                                            onsubmit="return confirm('Deseja cancelar esta inscrição?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger">
                                                Cancelar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>

            @if($loop->last)
                        </tbody>
                    </table>
                </div>
            @endif

        @empty

            <div class="alert alert-info mb-0">
                Você ainda não possui inscrições.
            </div>

        @endforelse

    </div>
</div>

@endsection
