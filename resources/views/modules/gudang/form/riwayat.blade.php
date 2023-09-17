

<div class="body">
    @foreach ($riwayat as $r)
        @php
            $color = '';
            if($r->flow == config('app.flow.rencana')){
                $color = 'blue';
            } else if($r->flow == config('app.flow.keluar')){
                $color = 'warning';
            } else if($r->flow == config('app.flow.stock')){
                $color = 'info';
            } else if($r->flow == config('app.flow.batal')){
                $color = 'danger';
            }
        @endphp
        <div class="timeline-item {{$color}}" date-is="{{$r->created_at}}">
            @if($r->flow != config('app.flow.batal'))
                <span>{{$r->keterangan}}</span>
                @if($r->flow != config('app.flow.rencana'))
                    <div class="msg my-1">
                        <p class="m-0 p-0">Uraian : {{$r->hasStockId->hasBarang->uraian}}</p>
                        <p class="m-0 p-0">Jumlah : {{$r->jumlah}} {{$r->hasStockId->hasBarang->satuan}}</p>
                        <p class="m-0 p-0">Stock saat ini : {{$r->hasStockId->stock}} {{$r->hasStockId->hasBarang->satuan}}</p>
                    </div>
                @else
                    <div class="msg my-1">
                        <p class="m-0 p-0">Draftcode : {{$r->draftcode}}</p>
                        <p class="m-0 p-0">Uraian : {{$r->hasStockId->hasBarang->uraian}}</p>
                        <p class="m-0 p-0">Jumlah Pembelian : {{$r->jumlah}} {{$r->hasStockId->hasBarang->satuan}}</p>
                    </div>
                @endif
            @else
                <span>Pembatalan Pembelian : {{$r->keterangan}}</span>
            @endif
        </div>
    @endforeach
</div>
