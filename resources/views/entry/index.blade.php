@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ __('Entry List') }}</h2>
                        <!-- <a href="{{ route('entries.create') }}" class="btn btn-primary">Create Entry</a> -->
                    </div>

                    <div class="card-body">
                        <table id="entryTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Quantity</th>
                                    <th>Entry Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#entryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('entries.index') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'entry_time', name: 'entry_time' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'asc']],
                rowId: 'id',
                stateSave: true,
                stripeClasses: ['bg-light', 'bg-white'],
                createdRow: function(row) {
                    $('td', row).css('border', '1px solid #ddd');
                }
            });
        });
    </script>
@endsection
