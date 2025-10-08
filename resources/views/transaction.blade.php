
<x-layouts.app :title="__('Transaction')">
    <x-header title="Transaction"/>
    <x-summary-card />
    <div class="grid auto-rows-min mb-4 gap-4 md:grid-cols-1">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-full table-fixed border-collapse">
                        <thead>
                        <tr class="bg-blue-800">
                            <th class="py-2 px-4 text-left">ID</th>
                            <th class="py-2 px-4 text-left">Savings</th>
                            <th class="py-2 px-4 text-left">Fee</th>
                            <th class="py-2 px-4 text-left">Type</th>
                            <th class="py-2 px-4 text-left">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $i = 1 + $transaction->currentPage() * $transaction->perPage() - $transaction->perPage();
                            @endphp
                            @if ($transaction->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-4" style="color: black; font-weight:600;">No transactions found.</td>
                                </tr>
                            @else
                                @foreach ($transaction as $t)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $t->wallet->bank->name }}</td>
                                    <td>{{ $t->business ? $t->business->occupant : '-' }}</td>
                                    <td>
                                    @if(!empty($t->totalItem->first()->grand_total))
                                        {{ number_format($t->totalItem->first()->grand_total) ?? '-' }}
                                    @else
                                    -
                                    @endif</td>
                                    <td><span class="status @if($t->type == 'Cash In') completed @else danger @endif">{{ $t->type }}</span></td>
                                    <td>
                                        <a class="btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    </div>
            </div>
        </div>
    </div>
</x-layouts.app>
