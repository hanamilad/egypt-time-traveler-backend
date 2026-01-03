<x-filament-panels::page>
    <div
        wire:ignore
        x-data="{
            calendar: null,
            isModalOpen: false,
            reminderBookingId: null,
            reminderMessage: 'Hello, looking forward to seeing you on the tour!',
            isSending: false,

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
                    eventContent: function(arg) {
                        if (arg.event.id.startsWith('soldout-')) {
                            return { domNodes: [] }; // Default rendering for sold out
                        }

                        let props = arg.event.extendedProps;
                        
                        let container = document.createElement('div');
                        container.className = 'p-1 flex flex-col gap-0.5 text-xs overflow-hidden';
                        container.style.whiteSpace = 'normal'; // Allow wrapping
                        container.style.wordBreak = 'break-word';

                        let line1 = document.createElement('div');
                        line1.className = 'font-bold text-slate-800';
                        line1.innerText = '1. ' + props.tourName;

                        let line2 = document.createElement('div');
                        line2.className = 'text-slate-600';
                        line2.innerText = '2. ' + props.guestName;

                        let line3 = document.createElement('div');
                        line3.className = 'text-slate-500';
                        line3.innerText = '3. ' + props.guestCount;

                        let btnContainer = document.createElement('div');
                        btnContainer.className = 'mt-1';
                        
                        let btn = document.createElement('button');
                        btn.innerText = 'Send Reminder';
                        // Standard Tailwind Blue classes to ensure it renders correctly without relying on dynamic primary colors
                        btn.className = 'mt-1 w-full rounded-lg bg-blue-600 px-2 py-1 text-[10px] font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition';
                        
                        btn.onclick = (e) => {
                            e.stopPropagation(); 
                            e.preventDefault();
                            window.dispatchEvent(new CustomEvent('open-reminder-modal', { 
                                detail: { 
                                    bookingId: props.bookingId,
                                    guestName: props.guestName
                                } 
                            }));
                        };

                        btnContainer.appendChild(btn);

                        container.appendChild(line1);
                        container.appendChild(line2);
                        container.appendChild(line3);
                        container.appendChild(btnContainer);

                        return { domNodes: [container] };
                    },
                    dateClick: (info) => {
                        if (confirm('Do you want to toggle (Sold Out) status for ' + info.dateStr + '?')) {
                            this.$wire.toggleSoldOut(info.dateStr);
                        }
                    },
                    eventClick: (info) => {
                        if (info.event.url) {
                            info.jsEvent.preventDefault();
                            window.location.href = info.event.url;
                            return;
                        }

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

                window.addEventListener('open-reminder-modal', (e) => {
                    this.reminderBookingId = e.detail.bookingId;
                    this.reminderMessage = `Hello ${e.detail.guestName},\n\nWe are looking forward to seeing you soon on your tour! Please let us know if you have any questions.\n\nBest regards,\nTimeTraveler`;
                    this.$dispatch('open-modal', { id: 'reminder-modal' }); 
                });

                window.addEventListener('reminder-sent', () => {
                    this.$dispatch('close-modal', { id: 'reminder-modal' });
                    this.isSending = false;
                });
            },

            sendReminder() {
                if(!this.reminderBookingId) return;
                this.isSending = true;
                this.$wire.sendReminder(this.reminderBookingId, this.reminderMessage)
                    .then(() => {
                        // Success handled by event listener
                    })
                    .catch(() => {
                        this.isSending = false;
                    });
            }
        }"
        class="p-4 bg-white rounded-xl shadow relative">
        <div x-ref="calendar"></div>

        <x-filament::modal id="reminder-modal" width="md">
            <x-slot name="heading">
                Send Reminder
            </x-slot>

            <div class="py-4">
                <textarea
                    x-model="reminderMessage"
                    rows="6"
                    style="width: 100%;"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-3">
                    <x-filament::button color="gray" x-on:click="$dispatch('close-modal', { id: 'reminder-modal' })">
                        Cancel
                    </x-filament::button>

                    <x-filament::button x-on:click="sendReminder">
                        <span x-show="!isSending">Send Email</span>
                        <span x-show="isSending">Sending...</span>
                    </x-filament::button>
                </div>
            </x-slot>
        </x-filament::modal>
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