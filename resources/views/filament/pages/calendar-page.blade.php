<x-filament-panels::page>
    <div 
        wire:ignore 
        x-data="{
            calendar: null,
            init() {
                this.calendar = new FullCalendar.Calendar(this.$refs.calendar, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: ''
                    },
                    events: (fetchInfo, successCallback, failureCallback) => {
                        this.$wire.getEvents(fetchInfo.startStr, fetchInfo.endStr)
                            .then(events => {
                                successCallback(events);
                            })
                            .catch(error => {
                                failureCallback(error);
                            });
                    },
                    dateClick: (info) => {
                        if (confirm('Do you want to toggle (Sold Out) status for ' + info.dateStr + '?')) {
                            this.$wire.toggleSoldOut(info.dateStr);
                        }
                    },
                    eventClick: (info) => {
                        if (info.event.id.startsWith('soldout-')) {
                            if (confirm('Do you want to re-open availability for ' + info.event.startStr + '?')) {
                                this.$wire.toggleSoldOut(info.event.startStr);
                            }
                        }
                    }
                });
                this.calendar.render();

                window.addEventListener('calendar-updated', () => {
                   this.calendar.refetchEvents();
                });
            }
        }"
        class="p-4 bg-white rounded-xl shadow"
    >
        <div x-ref="calendar"></div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    @endpush

    <style>
        #calendar {
            --fc-border-color: #e5e7eb;
            --fc-today-bg-color: #fef3c7;
            font-family: inherit;
        }
        .fc-event {
            cursor: pointer;
        }
    </style>
</x-filament-panels::page>
