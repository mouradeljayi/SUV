<template>
  <div>
    <FullCalendar :options="calendarOptions" />
    <b-modal id="eventInfo" title="les informations de l'événement">
      <h5>Titre de l'événement : {{ evenements.title }}</h5>
      <h5>Status de l'événement : {{ evenements.status.nom }}</h5>
      <h5>Type de l'événement : {{ evenements.type.nom }}</h5>
      <h5>description de l'événement : {{ evenements.description }}</h5>
     <p-button round
        type="info" 
        @click.native.prevent="editEvent(selectedEvent.id)">
        modifier
      </p-button>
      <p-button round 
        type="warning" 
        @click.native.prevent="archiver(selectedEvent.id)">
        Archiver
      </p-button>
    </b-modal>
  </div>
</template>
<script>
import axios from 'axios'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'
import Multiselect from 'vue-multiselect'
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";
import Vue from 'vue'
import { mutations } from "../../store";
Vue.component('multiselect', Multiselect)
export default {
    components: { FullCalendar },
    data() {
        return {
            options: [],
            stOptions: [],
            selectedEvent: '',
            typeEvenement: [],
            statusEvenement: [],
            evenements: {
                title: "",
                status: "",
                type: "",
                description: "",
                date: "",
                date_fin: ""
            },
            events: [],
            calendarOptions: {
            locale:"fr",
            weekends: false,
            selectable: true,
            editable: true,
            eventClick: this.handleEventClick,
            events: [],            
            select: this.addEvent,
            plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
            initialView: 'dayGridMonth',
            headerToolbar: {
            right: 'prev,next today',
            left: 'title',
            center: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today:'Aujourd\'hui',
                month:'Mois',
                week: 'Semaine',
                day:  'Jour',
            }
          }
        }
    },
    created() {
      this.listEvents()
      this.getStatus()
      this.getType()
    },
    methods: {
        listEvents(){
        axios.get("evenement/list").then(response => {
        response.data.forEach(element => {
            element.title = element.nom
            this.calendarOptions.events.push(element)
        });
      })
    },
     getStatus() {
      axios.get('type/status').then((response) => {
        this.statusEvenement = response.data
      })
    },
    getType() {
      axios.get('typeevenement/liste').then((response) => {
        this.typeEvenement = response.data
      })
    },
    addEvent(arg) {
       let dates =  {
        date: arg.start,
        date_fin: arg.end
       }
       mutations.setDates(dates)
       this.$router.push("/addEvent");  
    },
    editEvent(id) {
      this.$router.push("event/modifier/" + id);  
    },
    archiver(id) {
      axios.put("/evenement/archiver/" + id).then(response => {
        if(response.data.message === "Evenement archivée avec succès") {
          this.$notify({
            title: 'Evenement archivée',
            text: "Evenement archivée avec succès",
            type: 'danger',
            template: NotificationTemplate,
            icon: 'fa-regular fa-box-archive',
            horizontalAlign: 'center',
          });
          this.$router.go(0)
        }
      }).catch(error => {
        error.toString();
      });
      },
    handleEventClick(clickInfo) {
        this.$bvModal.show("eventInfo")
        this.selectedEvent = clickInfo.event
        this.evenements.title = clickInfo.event.title
        this.evenements.status = clickInfo.event.extendedProps.status
        this.evenements.description = clickInfo.event.extendedProps.description
        this.evenements.type = clickInfo.event.extendedProps.Type
    }
  }
}
</script>

<style scoped>
</style>