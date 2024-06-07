<div class="card">
    <div class="card-body">
        <div class="input-group mb-3">
            <form method="POST" action="{{route('transactions.search')}}">
                @csrf
                <input name="search" type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

