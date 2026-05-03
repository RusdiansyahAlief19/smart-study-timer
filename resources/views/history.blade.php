<x-app-layout>
    <div class="py-8 min-h-screen" style="background:#0d0f14;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="rounded-xl border p-4" style="border-color:#1e2330;background:#151820;">
                    <p class="text-xs" style="color:#6b7394;">Total Sesi</p>
                    <p class="text-xl font-bold mt-1" style="color:#e4e8f5;">{{ $summary['total_sessions'] }}</p>
                </div>
                <div class="rounded-xl border p-4" style="border-color:#1e2330;background:#151820;">
                    <p class="text-xs" style="color:#6b7394;">Streak Aktif</p>
                    <p class="text-xl font-bold mt-1" style="color:#60a5fa;">{{ $summary['current_streak'] }} hari</p>
                </div>
                <div class="rounded-xl border p-4" style="border-color:#1e2330;background:#151820;">
                    <p class="text-xs" style="color:#6b7394;">Streak Terpanjang</p>
                    <p class="text-xl font-bold mt-1" style="color:#a78bfa;">{{ $summary['longest_streak'] }} hari</p>
                </div>
                <div class="rounded-xl border p-4" style="border-color:#1e2330;background:#151820;">
                    <p class="text-xs" style="color:#6b7394;">Total Fokus</p>
                    <p class="text-xl font-bold mt-1" style="color:#34d399;">{{ $summary['total_focus_minutes'] }} min</p>
                </div>
            </div>

            <div class="rounded-2xl border overflow-hidden" style="border-color:#1e2330;background:#151820;">
                <div class="px-4 py-3 border-b" style="border-color:#1e2330;">
                    <h3 class="text-sm font-semibold" style="color:#e4e8f5;">Riwayat Sesi Belajar</h3>
                </div>

                @if ($recentSessions->count() === 0)
                    <div class="px-4 py-10 text-center text-sm" style="color:#6b7394;">
                        Belum ada sesi belajar tersimpan.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead style="background:#0f1219;color:#8e98be;">
                                <tr>
                                    <th class="text-left px-4 py-3 font-medium">Tanggal</th>
                                    <th class="text-left px-4 py-3 font-medium">Metode</th>
                                    <th class="text-left px-4 py-3 font-medium">Fokus Utama</th>
                                    <th class="text-left px-4 py-3 font-medium">Catatan Sesi</th>
                                    <th class="text-left px-4 py-3 font-medium">Durasi Fokus</th>
                                    <th class="text-left px-4 py-3 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentSessions as $session)
                                    <tr class="border-t" style="border-color:#1e2330;">
                                        <td class="px-4 py-3" style="color:#e4e8f5;">
                                            {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3" style="color:#9fb2f7;">
                                            {{ strtoupper($session->preset ?? 'custom') }}
                                        </td>
                                        <td class="px-4 py-3" style="color:#c9d4f6;">
                                            {{ $session->focus_note ?: '—' }}
                                        </td>
                                        <td class="px-4 py-3" style="color:#9fb2f7;">
                                            {{ $session->session_note ?: '—' }}
                                        </td>
                                        <td class="px-4 py-3" style="color:#e4e8f5;">
                                            {{ round($session->study_duration / 60) }} menit
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs rounded-full border" style="border-color:#2d3447;color:#9fb2f7;">
                                                {{ $session->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div>
                {{ $recentSessions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
