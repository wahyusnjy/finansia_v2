<x-layouts.app :title="__('Savings')">
    <x-header title="Savings"/>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-full">
        <!-- Summary Cards  -->
        <x-summary-card />
        <!-- Savings List and Transactions -->
        <div class="grid auto-rows-min mb-4 gap-4 md:grid-cols-1">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-full table-fixed border-collapse">
                        <thead>
                        <tr class="bg-blue-800">
                            <th class="py-2 px-4 text-left">ID</th>
                            <th class="py-2 px-4 text-left">Bank</th>
                            <th class="py-2 px-4 text-left">Account Number</th>
                            <th class="py-2 px-4 text-left">Balance</th>
                            <th class="py-2 px-4 text-left">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $i = 1 + $saving->currentPage() * $saving->perPage() - $saving->perPage();
                            @endphp
                            @if ($saving->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-4" style="color: black; font-weight:600;">No savings found.</td>
                                </tr>
                            @else
                                @foreach ($saving as $s)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $s->bank->name ?? '' }}</td>
                                        <td>{{ $s->rekening }}</td>
                                        <td>{{ number_format($s->saldo) }}</td>
                                        <td>
                                            <a class="btn-warning" href="{{ route('savings.edit',$s->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $saving->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layouts.app>
