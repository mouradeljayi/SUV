import DashboardLayout from "@/layout/dashboard/DashboardLayout.vue";
// GeneralViews
import NotFound from "@/pages/NotFoundPage.vue";
import Login from "@/pages/Login.vue";

// Admin pages
import Dashboard from "@/pages/Dashboard.vue";
import UserProfile from "@/pages/UserProfile.vue";
import Notifications from "@/pages/Notifications.vue";
import Icons from "@/pages/Icons.vue";
import Maps from "@/pages/Maps.vue";
import Typography from "@/pages/Typography.vue";
import TableList from "@/pages/TableList.vue";


import EvenementChoixCollaborateurs from "@/pages/Evenement/ChoixCollaborateurs"
import Event from "@/pages/Evenement/Event";
import AddEvent from "@/pages/Evenement/AddEvent";
import ModifierEvent from "@/pages/Evenement/Modifier"
import EmailQuestionnaire from "@/pages/Questionnaire/Email";
import QuestionnaireTitre from "@/pages/Questionnaire/QuestionTitre";
import QuestionnaireList from "@/pages/Questionnaire/Liste";
import ListeUtilisateurs from "@/pages/Utilisateurs/Liste.vue";
import AjouterUtilisateurs from "@/pages/Utilisateurs/Ajouter.vue";
import ModifierUtilisateurs from "@/pages/Utilisateurs/Modifier.vue";
import ListeTransports from "@/pages/Transport/Liste.vue";
import AjouterTransports  from "@/pages/Transport/Ajouter.vue";
import ModifierTransports from "@/pages/Transport/Modifier.vue";
import ActivitesListe from "@/pages/Activite/Liste";
import ActivitesAjouter from "@/pages/Activite/Ajouter";
import ActivitesModifier from "@/pages/Activite/Modifier";
import TypeEvenementListe from "@/pages/TypeEvenement/Liste";
import TypeEvenementAjouter from "@/pages/TypeEvenement/Ajouter";
import TypeEvenementModifier from "@/pages/TypeEvenement/Modifier";
import ClientVisiteurListe from "@/pages/ClientVisiteur/Liste";
import ClientVisiteurAjouter from "@/pages/ClientVisiteur/Ajouter";
import ClientVisiteurModifier from "@/pages/ClientVisiteur/Modifier";
import VisiteClientListe from "@/pages/VisiteClient/Liste";
import VisiteClientAjouter from "@/pages/VisiteClient/Ajouter";
import VisiteClientModifier from "@/pages/VisiteClient/Modifier";
import StatusList from "@/pages/TypeStatus/Liste";
import StatusAjouter from "@/pages/TypeStatus/Ajouter"
import StatusModifier from "@/pages/TypeStatus/Modifier";
import RestaurantList from "@/pages/Restaurant/Liste"
import RestaurantAjouter from "@/pages/Restaurant/Ajouter"
import RestaurantModifier from "@/pages/Restaurant/Modifier"
import HotelListe from "@/pages/Hotel/Liste"
import HotelAjouter from "@/pages/Hotel/Ajouter"
import HotelModifier from "@/pages/Hotel/Modifier"
import ModifierReservationTransports from "@/pages/ReservationTransport/Modifier"
import ModifierResrvationHotel from "@/pages/ReservationHotel/Modifier"
import ReservationRestaurantModifier from "@/pages/ReservationRestaurant/Modifier"
import ResultList from "@/pages/Result/Liste"
import PACList from "@/pages/PAC/Liste"
import AjouterReservation from "@/pages/Reservation/AjouterReservation"
import ListeReservation from "@/pages/Reservation/ListeReservation"
import TitreQuestionnaire from "@/pages/QuestionnaireConfirmation/Titre"
import ListeQuestionnaire from "@/pages/QuestionnaireConfirmation/Liste"
import FinalResult from "@/pages/FinalResult/Liste"
import ActivitesFinales from "@/pages/TAF/Liste"
import Agenda from "@/pages/Calendar/Agenda"

import jwtDecode from "jwt-decode";

const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/",
    component: DashboardLayout,
    redirect: "/dashboard",
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard
      },
      {
        path: "calendar",
        name: "Calendar",
        component: Agenda
      },
      {
        path: "event",
        name: "Liste des événements",
        component: Event
      },
      {
        path: "addEvent",
        name: "Ajout d'événement",
        component: AddEvent
      },
      {
        path: "event/modifier/:id",
        name: "Modifier événement",
        component: ModifierEvent
      },
      {
        path: "userchoice",
        name: "Choix des collaborateurs",
        component: EvenementChoixCollaborateurs
      },
      {
        path: "questionnaire",
        name: "Questionnaire",
        component: QuestionnaireList
      },
      {
        path: "pac/liste",
        name: "Liste_PAC",
        component: PACList
      },
      {
        path: "result",
        name: "Resultat",
        component: ResultList
      },
      {
        path: "restaurant",
        name: "Restaurant",
        component: RestaurantList
      },
      {
        path: "/restaurant/ajouter",
        name: "Ajouter_Restaurant",
        component: RestaurantAjouter
      },
      {
        path: "/restaurant/modifier/:id",
        name: "Modifier_Restaurant",
        component: RestaurantModifier
      },
      {
        path: "questionnaire/titre",
        name: "Questionnaire_Titre",
        component: QuestionnaireTitre
      },
      {
        path: "email",
        name: "Email",
        component: EmailQuestionnaire
      },
      {
        path: "reservation/restaurant/modifier/:id",
        name: "Modifier_Reservation_Restaurant",
        component: ReservationRestaurantModifier
      },
      {
        path: "status",
        name: "status",
        component: StatusList
      },
      {
        path: "status/ajouter",
        name: "ajouter_status",
        component: StatusAjouter
      },
      {
        path: "status/modifier/:id",
        name: "modifier_status",
        component: StatusModifier
      },
      {
        path: "addEvent",
        name: "addEvent",
        component: AddEvent
      },
      {
        path: "activites",
        name: "Liste des Activites",
        component: ActivitesListe
      },
      {
        path: "activites/ajouter",
        name: "Ajouter une Activite",
        component: ActivitesAjouter
      },
      {
        path: "activites/modifier/:id",
        name: "Modifier une Activite",
        component: ActivitesModifier
      },
      {
        path: "/utilisateurs",
        name: "Utilisateurs",
        component: ListeUtilisateurs,
        beforeEnter: (to, from, next) => {
          if(jwtDecode(localStorage.getItem('token')).roles[0] === "ROLE_ADMIN"){
            next();
          }
          else{
            next(false);
          }
        }
      },
      {
        path: "/utilisateurs/ajouter",
        name: "ajouter_utilisateurs",
        component: AjouterUtilisateurs,
      },
      {
        path: "/utilisateurs/modifier/:id",
        name: "modifier utilisateur",
        component: ModifierUtilisateurs,
      },
      {
        path: "/reservation/transport/modifier/:id",
        name: "modifier reservation_transport",
        component: ModifierReservationTransports,
      },
      {
        path: "/transport",
        name: "transports",
        component: ListeTransports,
      },
      {
        path: "/Transport/ajouter",
        name: "ajouter_transports",
        component: AjouterTransports,
      },
      {
        path: "/transport/modifier/:id",
        name: "modifier Transports",
        component: ModifierTransports,
      },
      {
        path: "/visiteclient/",
        name: "Liste visite client",
        component: VisiteClientListe,
      },
      {
        path: "/visiteclient/ajouter",
        name: "Ajouter visite client",
        component: VisiteClientAjouter,
      },
      {
        path: "/visiteclient/modifier/:id",
        name: "modifier visite client",
        component: VisiteClientModifier,
      },
      {
        path: "/clientvisiteur/",
        name: "Liste client visiteur",
        component: ClientVisiteurListe,
      },
      {
        path: "/clientvisiteur/ajouter",
        name: "Ajouter client visiteur",
        component: ClientVisiteurAjouter,
      },
      {
        path: "/clientvisiteur/modifier/:id",
        name: "modifier client visiteur",
        component: ClientVisiteurModifier,
      },
      {
        path: "/typeevenement/",
        name: "Liste type evenement",
        component: TypeEvenementListe,
      },
      {
        path: "/typeevenement/ajouter",
        name: "Ajouter type evenement",
        component: TypeEvenementAjouter,
      },
      {
        path: "/typeevenement/modifier/:id",
        name: "modifier type evenement",
        component: TypeEvenementModifier,
      },
      {
        path: "hotels",
        name: "Liste des Hôtels",
        component: HotelListe
      },
      {
        path: "hotel/ajouter",
        name: "Ajouter Un Hôtel",
        component: HotelAjouter
      },
      {
        path: "hotel/modifier/:id",
        name: "Modifier un hôtel",
        component: HotelModifier
      },
      {
        path: "reservation/hotel/modifier/:id",
        name: "Modifier une réservation d'hôtel",
        component: ModifierResrvationHotel
      },
      {
        path: "/reservation/ajouter",
        name: "Ajouter une Résérvation",
        component: AjouterReservation
      },
      {
        path: "/reservation/liste",
        name: "Liste des Réservations",
        component: ListeReservation
      },
      {
        path: "/titreQuestionnaire",
        name: "Titre de questionnaire de confirmation",
        component: TitreQuestionnaire
      },
      {
        path: "/listeQuestionnaire",
        name: "Liste questionnaire de confirmation",
        component: ListeQuestionnaire
      },
      {
        path: "/finalresult",
        name: "Résultat de questionnaire de confirmation",
        component: FinalResult
      },
      {
        path: "/TAF",
        name: "Liste des Activités Finales",
        component: ActivitesFinales
      },
      {
        path: "profile",
        name: "Profile",
        component: UserProfile
      },
      {
        path: "notifications",
        name: "notifications",
        component: Notifications
      },
      {
        path: "icons",
        name: "icons",
        component: Icons
      },
      {
        path: "maps",
        name: "maps",
        component: Maps
      },
      {
        path: "typography",
        name: "typography",
        component: Typography
      },
      {
        path: "table-list",
        name: "table-list",
        component: TableList
      }
    ]
  },
  { path: "*", component: NotFound }
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes;
