@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Agency</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Agency</a></div>
                <div class="breadcrumb-item">List</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List of Agency</h4>
                            <span class="text-right">
                            <a href="{{ route('agencies.create') }}" class="btn btn-sm btn-primary">Add agency</a>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th scope="col">Kod</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agencies as $agency)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $agency->code }}</td>
                                            <td>{{ $agency->name }}</td>
                                            <td class="text-right">
                                                <a class="btn btn-success" href="{{ route('agencies.show',$agency->id) }}">View</a>
                                                <a class="btn btn-primary" href="{{ route('agencies.edit',$agency->id) }}">Edit</a>
                                                {!! Form::open(['method' => 'DELETE','route' => ['agencies.destroy', $agency->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <nav class="d-flex justify-content-center" aria-label="pagination">
                                {!! $agencies->links() !!}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

