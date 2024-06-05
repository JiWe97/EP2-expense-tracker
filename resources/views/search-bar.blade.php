<div class="card">
    <div class="card-head pb-0 border-0">
        <h5>
            Search
        </h5>
    </div>
    <div class="card-body">
        <div class="input-group mb-3">
            <form method="GET" action="{{route('transactions.search')}}">
                <input name="search" type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@if($results->isEmpty())
    <!-- <p>No results found.</p> -->
@else
    <ul>
        @foreach($results as $result)
            <li>{{ $result->column_name }}</li> <!-- Adjust to display relevant data -->
        @endforeach
    </ul>
@endif

