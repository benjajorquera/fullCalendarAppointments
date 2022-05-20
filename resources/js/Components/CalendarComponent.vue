<template>
    <body class="pt-5">
        <div class="container">
            <h3>Welcome</h3>
            <h4>
                Click on any date and available hour to schedule a Dance with
                Death
            </h4>
            <h5>Click an event and confirm to delete it</h5>
            <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        </div>
    </body>
</template>
<script>
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

import axios from "axios";

export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                headerToolbar: {
                    start: "title", // will normally be on the left. if RTL, will be on the right
                    center: "",
                    end: "today prevYear,prev,next,nextYear", // will normally be on the right. if RTL, will be on the left
                },
                timeZone: "UTC",
                plugins: [interactionPlugin, dayGridPlugin],
                selectable: true,
                initialView: "dayGridMonth",
                eventSources: [],
                dateClick: this.handleDateClick,
                eventClick: this.handleEventClick,
                eventDisplay: "block",
                eventTimeFormat: {
                    hour: "2-digit",
                    minute: "2-digit",
                    //meridiem: "short",
                    hour12: false,
                },
            },
        };
    },
    methods: {
        getEvents() {
            const events = [];
            axios.get("/api/appointments").then((response) => {
                response.data.data.map((data) => {
                    events.push(data);
                });
                this.calendarOptions.eventSources.push({
                    events: events,
                    color: "grey",
                    id: 1,
                });
            });
        },
        handleEventClick: function (args) {
            if (args.event.title !== "Available") {
                var option = confirm(
                    "Appointment not available for schedule.\n\nDelete event?"
                );
                if (option) {
                    let calendarApi = this.$refs.fullCalendar.getApi();
                    axios
                        .delete("/api/appointments/" + args.event.id)
                        .then((response) => {
                            if (this.calendarOptions.eventSources.length < 2) {
                                args.event.remove();
                                return;
                            }

                            if (
                                args.event.start
                                    .toISOString()
                                    .substring(0, 10) ===
                                this.calendarOptions.eventSources[1].clickDate
                            ) {
                                calendarApi.addEvent(
                                    {
                                        title: "Available",
                                        start: args.event.start,
                                    },
                                    2
                                );
                            }
                            args.event.remove();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            } else {
                let calendarApi = this.$refs.fullCalendar.getApi();
                while (true) {
                    var contact = prompt("Enter email to schedule\n");
                    if (contact === null) return;
                    else if (contact === "") alert("Email can't be empty");
                    else if (!contact.match(/^\S+@\S+\.\S+$/))
                        alert("Email not valid");
                    else break;
                }
                axios
                    .post("/api/appointments", {
                        date: args.event.start.toISOString().replace("Z", ""),
                        contact: contact,
                    })
                    .then((response) => {
                        args.event.remove();
                        calendarApi.addEvent(
                            {
                                id: response.data.id,
                                title: contact,
                                start: response.data.date.replace("Z", ""),
                            },
                            true
                        );
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },

        handleDateClick: function (args) {
            if (this.calendarOptions.eventSources.length > 1) {
                if (
                    this.calendarOptions.eventSources[1].clickDate ==
                    args.dateStr
                ) {
                    this.calendarOptions.eventSources.pop();
                    return;
                }
            }
            const events = [];
            axios
                .get("/api/appointments/findByDate/" + args.dateStr)
                .then((response) => {
                    if (this.calendarOptions.eventSources.length > 1) {
                        this.calendarOptions.eventSources.pop();
                    }
                    for (var i = 9; i < 18; i++) {
                        const getAppointment = response.data.data.find(
                            (appointment) =>
                                new Date(appointment.start).getHours() === i
                        );
                        if (!getAppointment) {
                            if (i === 9) var hourString = "09:00:00";
                            else var hourString = i + ":00:00";
                            const event = {
                                title: "Available",
                                start: args.dateStr + " " + hourString,
                            };
                            events.push(event);
                        }
                    }
                    this.calendarOptions.eventSources.push({
                        events: events,
                        color: "green",
                        id: 2,
                        clickDate: args.dateStr,
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
    created() {
        this.getEvents();
    },
};
</script>
