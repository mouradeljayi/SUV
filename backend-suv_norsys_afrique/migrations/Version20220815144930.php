<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815144930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, du DATETIME NOT NULL, au DATETIME NOT NULL, nbr_de_jours INT NOT NULL, motif VARCHAR(255) NOT NULL, INDEX IDX_765AE0C9FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, responsable_etude_id INT NOT NULL, questionnaire_activites_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date DATETIME NOT NULL, montant DOUBLE PRECISION NOT NULL, detail_montant VARCHAR(255) NOT NULL, cotisation DOUBLE PRECISION NOT NULL, cotisation_entreprise DOUBLE PRECISION NOT NULL, cotisation_par_salarie DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, prix_global_par_salarie DOUBLE PRECISION NOT NULL, participant INT NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_B87555156303BF78 (responsable_etude_id), INDEX IDX_B8755515606B35A5 (questionnaire_activites_id), INDEX IDX_B8755515FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier_reunion (calendrier_id INT NOT NULL, reunion_id INT NOT NULL, INDEX IDX_B8DA8053FF52FC51 (calendrier_id), INDEX IDX_B8DA80534E9B7368 (reunion_id), PRIMARY KEY(calendrier_id, reunion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier_tache (calendrier_id INT NOT NULL, tache_id INT NOT NULL, INDEX IDX_DA90A103FF52FC51 (calendrier_id), INDEX IDX_DA90A103D2235D39 (tache_id), PRIMARY KEY(calendrier_id, tache_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier_evenement (calendrier_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_AF069B4BFF52FC51 (calendrier_id), INDEX IDX_AF069B4BFD02F13 (evenement_id), PRIMARY KEY(calendrier_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier_projet (calendrier_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_E93A5F21FF52FC51 (calendrier_id), INDEX IDX_E93A5F21C18272 (projet_id), PRIMARY KEY(calendrier_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_visiteur (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, INDEX IDX_6043B77DFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, status_id INT NOT NULL, nom VARCHAR(255) NOT NULL, participants INT DEFAULT NULL, montant_global DOUBLE PRECISION DEFAULT NULL, subvention_entreprise DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, archive TINYINT(1) DEFAULT NULL, date_fin_evenement DATE DEFAULT NULL, INDEX IDX_B26681EC54C8C93 (type_id), INDEX IDX_B26681E6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_utilisateur (evenement_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_8C897598FD02F13 (evenement_id), INDEX IDX_8C897598FB88E14F (utilisateur_id), PRIMARY KEY(evenement_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE final_result (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, pac_id INT DEFAULT NULL, vote TINYINT(1) NOT NULL, INDEX IDX_E3644A04FB88E14F (utilisateur_id), INDEX IDX_E3644A04AE21B650 (pac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pac (id INT AUTO_INCREMENT NOT NULL, activite_id INT DEFAULT NULL, questionnaire_confirmation_id INT DEFAULT NULL, INDEX IDX_3EDDB469B0F88B1 (activite_id), INDEX IDX_3EDDB462E0C20B4 (questionnaire_confirmation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pac_utilisateur (pac_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_4B1016A6AE21B650 (pac_id), INDEX IDX_4B1016A6FB88E14F (utilisateur_id), PRIMARY KEY(pac_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, pilote_id INT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_50159CA9F510AAE9 (pilote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_activites (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_confirmation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_hotel (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, evenement_id INT DEFAULT NULL, date_entree DATE NOT NULL, date_sortie DATE NOT NULL, nbr_personne INT NOT NULL, chambre VARCHAR(255) NOT NULL, nbr_nuit_par_personne INT NOT NULL, total_nuitee INT NOT NULL, INDEX IDX_402C8E7E3243BB18 (hotel_id), INDEX IDX_402C8E7EFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_restaurant (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, evenement_id INT DEFAULT NULL, date_entree DATE NOT NULL, nbr_personne INT NOT NULL, archive TINYINT(1) NOT NULL, INDEX IDX_8B3FDB8BB1E7706E (restaurant_id), INDEX IDX_8B3FDB8BFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_transport (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, evenement_id INT DEFAULT NULL, date DATETIME NOT NULL, lieu_depart VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, nombre_pax INT NOT NULL, INDEX IDX_7CEC40B19909C13F (transport_id), INDEX IDX_7CEC40B1FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, activite_id INT DEFAULT NULL, questionnaire_id INT DEFAULT NULL, vote TINYINT(1) DEFAULT NULL, INDEX IDX_136AC113FB88E14F (utilisateur_id), INDEX IDX_136AC1139B0F88B1 (activite_id), INDEX IDX_136AC113CE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, sujet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reunion_utilisateur (reunion_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_7EFE36534E9B7368 (reunion_id), INDEX IDX_7EFE3653FB88E14F (utilisateur_id), PRIMARY KEY(reunion_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, absence_id INT DEFAULT NULL, encadrant_id INT DEFAULT NULL, sujet_stage_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, diplome VARCHAR(255) DEFAULT NULL, universite VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, formation_actuelle VARCHAR(255) DEFAULT NULL, technomaker TINYINT(1) NOT NULL, INDEX IDX_4F62F7312DFF238F (absence_id), INDEX IDX_4F62F731FEF1BA4 (encadrant_id), INDEX IDX_4F62F731167B3B62 (sujet_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taf (id INT AUTO_INCREMENT NOT NULL, pac_id INT DEFAULT NULL, INDEX IDX_748E8715AE21B650 (pac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taf_utilisateur (taf_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_DC43C0D626E0474 (taf_id), INDEX IDX_DC43C0D6FB88E14F (utilisateur_id), PRIMARY KEY(taf_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_evenement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, code_postal INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite_client (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, transport_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, evenement_id INT DEFAULT NULL, jour DATE DEFAULT NULL, programme_de_jour LONGTEXT DEFAULT NULL, heure TIME DEFAULT NULL, nombre_de_pax INT DEFAULT NULL, INDEX IDX_7CF3A8A43243BB18 (hotel_id), INDEX IDX_7CF3A8A49909C13F (transport_id), INDEX IDX_7CF3A8A4B1E7706E (restaurant_id), INDEX IDX_7CF3A8A4FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B87555156303BF78 FOREIGN KEY (responsable_etude_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515606B35A5 FOREIGN KEY (questionnaire_activites_id) REFERENCES questionnaire_activites (id)');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE calendrier_reunion ADD CONSTRAINT FK_B8DA8053FF52FC51 FOREIGN KEY (calendrier_id) REFERENCES calendrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_reunion ADD CONSTRAINT FK_B8DA80534E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_tache ADD CONSTRAINT FK_DA90A103FF52FC51 FOREIGN KEY (calendrier_id) REFERENCES calendrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_tache ADD CONSTRAINT FK_DA90A103D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_evenement ADD CONSTRAINT FK_AF069B4BFF52FC51 FOREIGN KEY (calendrier_id) REFERENCES calendrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_evenement ADD CONSTRAINT FK_AF069B4BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_projet ADD CONSTRAINT FK_E93A5F21FF52FC51 FOREIGN KEY (calendrier_id) REFERENCES calendrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendrier_projet ADD CONSTRAINT FK_E93A5F21C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_visiteur ADD CONSTRAINT FK_6043B77DFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC54C8C93 FOREIGN KEY (type_id) REFERENCES type_evenement (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6BF700BD FOREIGN KEY (status_id) REFERENCES status_evenement (id)');
        $this->addSql('ALTER TABLE evenement_utilisateur ADD CONSTRAINT FK_8C897598FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_utilisateur ADD CONSTRAINT FK_8C897598FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE final_result ADD CONSTRAINT FK_E3644A04FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE final_result ADD CONSTRAINT FK_E3644A04AE21B650 FOREIGN KEY (pac_id) REFERENCES pac (id)');
        $this->addSql('ALTER TABLE pac ADD CONSTRAINT FK_3EDDB469B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE pac ADD CONSTRAINT FK_3EDDB462E0C20B4 FOREIGN KEY (questionnaire_confirmation_id) REFERENCES questionnaire_confirmation (id)');
        $this->addSql('ALTER TABLE pac_utilisateur ADD CONSTRAINT FK_4B1016A6AE21B650 FOREIGN KEY (pac_id) REFERENCES pac (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pac_utilisateur ADD CONSTRAINT FK_4B1016A6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9F510AAE9 FOREIGN KEY (pilote_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_hotel ADD CONSTRAINT FK_402C8E7E3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE reservation_hotel ADD CONSTRAINT FK_402C8E7EFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE reservation_restaurant ADD CONSTRAINT FK_8B3FDB8BB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE reservation_restaurant ADD CONSTRAINT FK_8B3FDB8BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE reservation_transport ADD CONSTRAINT FK_7CEC40B19909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE reservation_transport ADD CONSTRAINT FK_7CEC40B1FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1139B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire_activites (id)');
        $this->addSql('ALTER TABLE reunion_utilisateur ADD CONSTRAINT FK_7EFE36534E9B7368 FOREIGN KEY (reunion_id) REFERENCES reunion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reunion_utilisateur ADD CONSTRAINT FK_7EFE3653FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F7312DFF238F FOREIGN KEY (absence_id) REFERENCES absence (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731FEF1BA4 FOREIGN KEY (encadrant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731167B3B62 FOREIGN KEY (sujet_stage_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE taf ADD CONSTRAINT FK_748E8715AE21B650 FOREIGN KEY (pac_id) REFERENCES pac (id)');
        $this->addSql('ALTER TABLE taf_utilisateur ADD CONSTRAINT FK_DC43C0D626E0474 FOREIGN KEY (taf_id) REFERENCES taf (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taf_utilisateur ADD CONSTRAINT FK_DC43C0D6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite_client ADD CONSTRAINT FK_7CF3A8A43243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE visite_client ADD CONSTRAINT FK_7CF3A8A49909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE visite_client ADD CONSTRAINT FK_7CF3A8A4B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE visite_client ADD CONSTRAINT FK_7CF3A8A4FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F7312DFF238F');
        $this->addSql('ALTER TABLE pac DROP FOREIGN KEY FK_3EDDB469B0F88B1');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1139B0F88B1');
        $this->addSql('ALTER TABLE calendrier_reunion DROP FOREIGN KEY FK_B8DA8053FF52FC51');
        $this->addSql('ALTER TABLE calendrier_tache DROP FOREIGN KEY FK_DA90A103FF52FC51');
        $this->addSql('ALTER TABLE calendrier_evenement DROP FOREIGN KEY FK_AF069B4BFF52FC51');
        $this->addSql('ALTER TABLE calendrier_projet DROP FOREIGN KEY FK_E93A5F21FF52FC51');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515FD02F13');
        $this->addSql('ALTER TABLE calendrier_evenement DROP FOREIGN KEY FK_AF069B4BFD02F13');
        $this->addSql('ALTER TABLE client_visiteur DROP FOREIGN KEY FK_6043B77DFD02F13');
        $this->addSql('ALTER TABLE evenement_utilisateur DROP FOREIGN KEY FK_8C897598FD02F13');
        $this->addSql('ALTER TABLE reservation_hotel DROP FOREIGN KEY FK_402C8E7EFD02F13');
        $this->addSql('ALTER TABLE reservation_restaurant DROP FOREIGN KEY FK_8B3FDB8BFD02F13');
        $this->addSql('ALTER TABLE reservation_transport DROP FOREIGN KEY FK_7CEC40B1FD02F13');
        $this->addSql('ALTER TABLE visite_client DROP FOREIGN KEY FK_7CF3A8A4FD02F13');
        $this->addSql('ALTER TABLE reservation_hotel DROP FOREIGN KEY FK_402C8E7E3243BB18');
        $this->addSql('ALTER TABLE visite_client DROP FOREIGN KEY FK_7CF3A8A43243BB18');
        $this->addSql('ALTER TABLE final_result DROP FOREIGN KEY FK_E3644A04AE21B650');
        $this->addSql('ALTER TABLE pac_utilisateur DROP FOREIGN KEY FK_4B1016A6AE21B650');
        $this->addSql('ALTER TABLE taf DROP FOREIGN KEY FK_748E8715AE21B650');
        $this->addSql('ALTER TABLE calendrier_projet DROP FOREIGN KEY FK_E93A5F21C18272');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731167B3B62');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515606B35A5');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113CE07E8FF');
        $this->addSql('ALTER TABLE pac DROP FOREIGN KEY FK_3EDDB462E0C20B4');
        $this->addSql('ALTER TABLE reservation_restaurant DROP FOREIGN KEY FK_8B3FDB8BB1E7706E');
        $this->addSql('ALTER TABLE visite_client DROP FOREIGN KEY FK_7CF3A8A4B1E7706E');
        $this->addSql('ALTER TABLE calendrier_reunion DROP FOREIGN KEY FK_B8DA80534E9B7368');
        $this->addSql('ALTER TABLE reunion_utilisateur DROP FOREIGN KEY FK_7EFE36534E9B7368');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6BF700BD');
        $this->addSql('ALTER TABLE calendrier_tache DROP FOREIGN KEY FK_DA90A103D2235D39');
        $this->addSql('ALTER TABLE taf_utilisateur DROP FOREIGN KEY FK_DC43C0D626E0474');
        $this->addSql('ALTER TABLE reservation_transport DROP FOREIGN KEY FK_7CEC40B19909C13F');
        $this->addSql('ALTER TABLE visite_client DROP FOREIGN KEY FK_7CF3A8A49909C13F');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC54C8C93');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9FB88E14F');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B87555156303BF78');
        $this->addSql('ALTER TABLE evenement_utilisateur DROP FOREIGN KEY FK_8C897598FB88E14F');
        $this->addSql('ALTER TABLE final_result DROP FOREIGN KEY FK_E3644A04FB88E14F');
        $this->addSql('ALTER TABLE pac_utilisateur DROP FOREIGN KEY FK_4B1016A6FB88E14F');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9F510AAE9');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113FB88E14F');
        $this->addSql('ALTER TABLE reunion_utilisateur DROP FOREIGN KEY FK_7EFE3653FB88E14F');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731FEF1BA4');
        $this->addSql('ALTER TABLE taf_utilisateur DROP FOREIGN KEY FK_DC43C0D6FB88E14F');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE calendrier');
        $this->addSql('DROP TABLE calendrier_reunion');
        $this->addSql('DROP TABLE calendrier_tache');
        $this->addSql('DROP TABLE calendrier_evenement');
        $this->addSql('DROP TABLE calendrier_projet');
        $this->addSql('DROP TABLE client_visiteur');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_utilisateur');
        $this->addSql('DROP TABLE final_result');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE pac');
        $this->addSql('DROP TABLE pac_utilisateur');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE questionnaire_activites');
        $this->addSql('DROP TABLE questionnaire_confirmation');
        $this->addSql('DROP TABLE reservation_hotel');
        $this->addSql('DROP TABLE reservation_restaurant');
        $this->addSql('DROP TABLE reservation_transport');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE reunion');
        $this->addSql('DROP TABLE reunion_utilisateur');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE status_evenement');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE taf');
        $this->addSql('DROP TABLE taf_utilisateur');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE visite_client');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
