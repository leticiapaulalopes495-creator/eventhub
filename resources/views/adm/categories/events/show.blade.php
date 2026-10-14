@extends('layouts.app')

@section('title', $event->title)

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <span class="badge text-bg-secondary mb-3">
            {{ $event->category->name }}
        </span>

        <h1 class="h3 mb-3">
            {{ $event->title }}
        </h1>

        <p>
            {{ $event->description }}
        </p>

        <hr>

        <p>
            <strong>Local:</strong>
            {{ $event->location }}
        </p>

        <p>
            <strong>Início:</strong>
            {{ $event->start_at->format('d/m/Y H:i') }}
        </p>

        <p>
            <strong>Término:</strong>
            {{ $event->end_at->format('d/m/Y H:i') }}
        </p>

        <p>
            <strong>Vagas:</strong>
            {{ $confirmedCount }} / {{ $event->capacity }}
        </p>

        <hr>

        <h2 class="h5 mb-3">
            Inscrição
        </h2>

        @php
            $available = $event->capacity - $confirmedCount;

            $canRegister = $event->status === 'scheduled'
                && !$event->hasStarted()
                && $available > 0;
        @endphp

        @if($event->isCanceled())

            <div class="alert alert-danger">
                Este evento foi cancelado.
            </div>

        @elseif($event->hasFinished())

            <div class="alert alert-secondary">
                Este evento já foi encerrado.
            </div>

        @elseif($event->hasStarted())

            <div class="alert alert-warning">
                Este evento já começou.
            </div>

        @elseif($registration?->isConfirmed())

            <div class="alert alert-success">
                Você está inscrito neste evento.
            </div>

            <form
                method="POST"
                action="{{ route('registrations.destroy', $registration) }}"
            >
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">
                    Cancelar inscrição
                </button>
            </form>

        @elseif(!$canRegister)

            <div class="alert alert-warning">
                Não existem vagas disponíveis.
            </div>

        @else

            <p>
                Vagas disponíveis:
                <strong>{{ $available }}</strong>
            </p>

            <form
                method="POST"
                action="{{ route('registrations.store', $event) }}"
            >
                @csrf

                <button class="btn btn-primary">
                    {{ $registration?->isCanceled()
                        ? 'Realizar nova inscrição'
                        : 'Inscrever-se'
                    }}
                </button>
            </form>

        @endif

        <a
            href="{{ route('events.index') }}"
            class="btn btn-outline-secondary mt-3"
        >
            Voltar aos eventos
        </a>

    </div>
</div>

@endsection
