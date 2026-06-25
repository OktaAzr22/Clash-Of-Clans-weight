@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>
            Clasher Stay - Ready War
        </h3>

        <a
            href="{{ route('base-groups.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    
        <table class="table table-bordered align-middle">

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>TH</th>
                    <th>Status War</th>
                </tr>
            </thead>

            <tbody>

                @foreach($clashers as $clasher)

                    <tr>

                        <td>
                            {{ $clasher->name }}
                        </td>

                        <td>
                            TH {{ $clasher->town_hall }}
                        </td>

                        <td>

    <div class="d-flex gap-4">

        <label>

            <input
                type="radio"
                name="war_status_{{ $clasher->id }}"
                value="1"
                data-id="{{ $clasher->id }}"
                {{ $clasher->is_ready_war ? 'checked' : '' }}
            >

            Siap War

        </label>


        <label>

            <input
                type="radio"
                name="war_status_{{ $clasher->id }}"
                value="0"
                data-id="{{ $clasher->id }}"
                {{ !$clasher->is_ready_war ? 'checked' : '' }}
            >

            Tidak Siap

        </label>

    </div>

</td>

                    </tr>

                @endforeach

            </tbody>

        </table>

       

   

</div>
<script>

document.querySelectorAll('input[type=radio]')
.forEach(radio => {

    radio.addEventListener('change', function(){

        fetch(
            '/base-groups/war-ready/' + this.dataset.id,
            {
                method: 'POST',

                headers:{
                    'Content-Type':'application/json',

                    'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
                },

                body: JSON.stringify({

                    status: this.value

                })

            }
        );

    });

});

</script>
@endsection