<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200913154613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abilities (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, base_strength INTEGER NOT NULL, base_dexterity INTEGER NOT NULL, base_constitution INTEGER NOT NULL, base_intelligence INTEGER NOT NULL, base_wisdom INTEGER NOT NULL, base_charisma INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE armor (id INTEGER NOT NULL, ac INTEGER NOT NULL, category VARCHAR(255) NOT NULL, maxDexterityBonus INTEGER NOT NULL, armorCheckPenalty INTEGER NOT NULL, arcaneSpellFailure INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE belt (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE body (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, race_id INTEGER DEFAULT NULL, abilities_id INTEGER DEFAULT NULL, equipment_id INTEGER DEFAULT NULL, party_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, lost_hp INTEGER NOT NULL, general_notes VARCHAR(255) DEFAULT NULL, power_notes VARCHAR(255) DEFAULT NULL, inventory_notes VARCHAR(255) DEFAULT NULL, spell_notes VARCHAR(255) DEFAULT NULL, non_prepared_cast_spells_count CLOB DEFAULT NULL --(DC2Type:json)
        , favoredClass INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_937AB034A76ED395 ON character (user_id)');
        $this->addSql('CREATE INDEX IDX_937AB0346E59D40D ON character (race_id)');
        $this->addSql('CREATE INDEX IDX_937AB0341B5B84B0 ON character (favoredClass)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB0341E1F6EAC ON character (abilities_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB034517FE9FE ON character (equipment_id)');
        $this->addSql('CREATE INDEX IDX_937AB034213C1059 ON character (party_id)');
        $this->addSql('CREATE TABLE character_spells (character_id INTEGER NOT NULL, classspell_id INTEGER NOT NULL, PRIMARY KEY(character_id, classspell_id))');
        $this->addSql('CREATE INDEX IDX_2B95CCC81136BE75 ON character_spells (character_id)');
        $this->addSql('CREATE INDEX IDX_2B95CCC8F6A34F8C ON character_spells (classspell_id)');
        $this->addSql('CREATE TABLE character_conditions (character_id INTEGER NOT NULL, condition_id INTEGER NOT NULL, PRIMARY KEY(character_id, condition_id))');
        $this->addSql('CREATE INDEX IDX_45EAB02F1136BE75 ON character_conditions (character_id)');
        $this->addSql('CREATE INDEX IDX_45EAB02F887793B6 ON character_conditions (condition_id)');
        $this->addSql('CREATE TABLE character_class_power (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level INTEGER DEFAULT NULL, class_power INTEGER DEFAULT NULL, child_power INTEGER DEFAULT NULL, active BOOLEAN NOT NULL, extra_information VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_49378A3A9AEACC13 ON character_class_power (level)');
        $this->addSql('CREATE INDEX IDX_49378A3A4D5D2096 ON character_class_power (class_power)');
        $this->addSql('CREATE INDEX IDX_49378A3AF88CA333 ON character_class_power (child_power)');
        $this->addSql('CREATE TABLE character_equipment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, main_weapon_item_id INTEGER DEFAULT NULL, offhand_weapon_item_id INTEGER DEFAULT NULL, armor_item_id INTEGER DEFAULT NULL, body_item_id INTEGER DEFAULT NULL, chest_item_id INTEGER DEFAULT NULL, left_finger_item_id INTEGER DEFAULT NULL, right_finger_item_id INTEGER DEFAULT NULL, feet_item_id INTEGER DEFAULT NULL, neck_item_id INTEGER DEFAULT NULL, back_item_id INTEGER DEFAULT NULL, eyes_item_id INTEGER DEFAULT NULL, head_item_id INTEGER DEFAULT NULL, headband_item_id INTEGER DEFAULT NULL, belt_item_id INTEGER DEFAULT NULL, hands_item_id INTEGER DEFAULT NULL, wrists_item_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_546877B839545950 ON character_equipment (main_weapon_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B81A6C361 ON character_equipment (offhand_weapon_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8729C59E9 ON character_equipment (armor_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8FB99EBC8 ON character_equipment (body_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8A41096 ON character_equipment (chest_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8F880B21D ON character_equipment (left_finger_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8522BD3E4 ON character_equipment (right_finger_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B84BD045A ON character_equipment (feet_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B87CD68F43 ON character_equipment (neck_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8C905B140 ON character_equipment (back_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8B3AEED6F ON character_equipment (eyes_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B848A7354F ON character_equipment (head_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8905F4F2C ON character_equipment (headband_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8FBAE14EF ON character_equipment (belt_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B8F8F6E5B8 ON character_equipment (hands_item_id)');
        $this->addSql('CREATE INDEX IDX_546877B863037D5E ON character_equipment (wrists_item_id)');
        $this->addSql('CREATE TABLE character_feat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level INTEGER DEFAULT NULL, feat INTEGER DEFAULT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_4D6785539AEACC13 ON character_feat (level)');
        $this->addSql('CREATE INDEX IDX_4D6785535A9B91CB ON character_feat (feat)');
        $this->addSql('CREATE TABLE chest (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE class_definition (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, sub_classes_number INTEGER DEFAULT NULL, hp_dice INTEGER NOT NULL, skill_points INTEGER NOT NULL, bab CLOB NOT NULL --(DC2Type:json)
        , reflexes CLOB NOT NULL --(DC2Type:json)
        , fortitude CLOB NOT NULL --(DC2Type:json)
        , will CLOB NOT NULL --(DC2Type:json)
        , spells_per_day CLOB DEFAULT NULL --(DC2Type:json)
        , casting_ability VARCHAR(255) DEFAULT NULL, preparation_needed BOOLEAN NOT NULL, known_spells_per_level CLOB DEFAULT NULL --(DC2Type:json)
        , able_to_learn_lower_level_spells BOOLEAN DEFAULT \'0\' NOT NULL, able_to_learn_new_spells BOOLEAN DEFAULT \'0\' NOT NULL, prestige BOOLEAN DEFAULT \'0\' NOT NULL)');
        $this->addSql('CREATE TABLE class_skills (class_id INTEGER NOT NULL, skill_id INTEGER NOT NULL, PRIMARY KEY(class_id, skill_id))');
        $this->addSql('CREATE INDEX IDX_1A6D54C8EA000B10 ON class_skills (class_id)');
        $this->addSql('CREATE INDEX IDX_1A6D54C85585C142 ON class_skills (skill_id)');
        $this->addSql('CREATE TABLE class_power (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER DEFAULT NULL, subclass_id INTEGER DEFAULT NULL, level INTEGER DEFAULT NULL, castable BOOLEAN DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE INDEX IDX_4D5D2096EA000B10 ON class_power (class_id)');
        $this->addSql('CREATE INDEX IDX_4D5D2096E190B699 ON class_power (subclass_id)');
        $this->addSql('CREATE TABLE class_power_children (child_id INTEGER NOT NULL, parent_id INTEGER NOT NULL, PRIMARY KEY(child_id, parent_id))');
        $this->addSql('CREATE INDEX IDX_3E6A3CFDDD62C21B ON class_power_children (child_id)');
        $this->addSql('CREATE INDEX IDX_3E6A3CFD727ACA70 ON class_power_children (parent_id)');
        $this->addSql('CREATE TABLE class_spell (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER DEFAULT NULL, subclass_id INTEGER DEFAULT NULL, spell_id INTEGER DEFAULT NULL, spell_level SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_36E8ECBBEA000B10 ON class_spell (class_id)');
        $this->addSql('CREATE INDEX IDX_36E8ECBBE190B699 ON class_spell (subclass_id)');
        $this->addSql('CREATE INDEX IDX_36E8ECBB479EC90D ON class_spell (spell_id)');
        $this->addSql('CREATE TABLE condition (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE counter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, character_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, max INTEGER NOT NULL, current INTEGER NOT NULL, reset_on_sleep BOOLEAN NOT NULL, persistent BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C1229478989D9B62 ON counter (slug)');
        $this->addSql('CREATE INDEX IDX_C12294781136BE75 ON counter (character_id)');
        $this->addSql('CREATE TABLE eyes (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE feat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE feet (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hands (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE head (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE headband (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE inventory_items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, character_id INTEGER DEFAULT NULL, item_id INTEGER DEFAULT NULL, quantity INTEGER DEFAULT 1 NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3D82424D1136BE75 ON inventory_items (character_id)');
        $this->addSql('CREATE INDEX IDX_3D82424D126F525E ON inventory_items (item_id)');
        $this->addSql('CREATE TABLE item (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cost INTEGER NOT NULL, weight NUMERIC(5, 2) NOT NULL, discr VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE ItemPowers (item_id INTEGER NOT NULL, power_id INTEGER NOT NULL, PRIMARY KEY(item_id, power_id))');
        $this->addSql('CREATE INDEX IDX_251D1748126F525E ON ItemPowers (item_id)');
        $this->addSql('CREATE INDEX IDX_251D1748AB4FC384 ON ItemPowers (power_id)');
        $this->addSql('CREATE TABLE item_power (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        , type VARCHAR(255) NOT NULL, cost INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE item_power_effect (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, character_id INTEGER NOT NULL, power_id INTEGER NOT NULL, active BOOLEAN NOT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE INDEX IDX_6DC2BD4C1136BE75 ON item_power_effect (character_id)');
        $this->addSql('CREATE INDEX IDX_6DC2BD4CAB4FC384 ON item_power_effect (power_id)');
        $this->addSql('CREATE TABLE level (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, character INTEGER DEFAULT NULL, class INTEGER DEFAULT NULL, parent_class INTEGER DEFAULT NULL, hp_roll INTEGER NOT NULL, extra_point VARCHAR(255) DEFAULT NULL, extra_ability VARCHAR(255) DEFAULT NULL, value INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9AEACC13937AB034 ON level (character)');
        $this->addSql('CREATE INDEX IDX_9AEACC13ED4B199F ON level (class)');
        $this->addSql('CREATE INDEX IDX_9AEACC13217A8D3C ON level (parent_class)');
        $this->addSql('CREATE TABLE levels_subclasses (level_id INTEGER NOT NULL, subclass_id INTEGER NOT NULL, PRIMARY KEY(level_id, subclass_id))');
        $this->addSql('CREATE INDEX IDX_C60CD6565FB14BA7 ON levels_subclasses (level_id)');
        $this->addSql('CREATE INDEX IDX_C60CD656E190B699 ON levels_subclasses (subclass_id)');
        $this->addSql('CREATE TABLE levels_spells (level_id INTEGER NOT NULL, classspell_id INTEGER NOT NULL, PRIMARY KEY(level_id, classspell_id))');
        $this->addSql('CREATE INDEX IDX_7E95BADE5FB14BA7 ON levels_spells (level_id)');
        $this->addSql('CREATE INDEX IDX_7E95BADEF6A34F8C ON levels_spells (classspell_id)');
        $this->addSql('CREATE TABLE level_skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level_id INTEGER DEFAULT NULL, skill_id INTEGER DEFAULT NULL, value INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_34E4E17E5FB14BA7 ON level_skill (level_id)');
        $this->addSql('CREATE INDEX IDX_34E4E17E5585C142 ON level_skill (skill_id)');
        $this->addSql('CREATE TABLE neck (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, dm_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_89954EE0FADC156C ON party (dm_id)');
        $this->addSql('CREATE TABLE power_effect (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, caster_id INTEGER DEFAULT NULL, character_id INTEGER NOT NULL, power_id INTEGER NOT NULL, caster_level SMALLINT NOT NULL, active BOOLEAN NOT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE INDEX IDX_A298408DDB710083 ON power_effect (caster_id)');
        $this->addSql('CREATE INDEX IDX_A298408D1136BE75 ON power_effect (character_id)');
        $this->addSql('CREATE INDEX IDX_A298408DAB4FC384 ON power_effect (power_id)');
        $this->addSql('CREATE TABLE prepared_spell (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, character_id INTEGER DEFAULT NULL, spell_id INTEGER DEFAULT NULL, class_id INTEGER DEFAULT NULL, already_cast BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_43E888201136BE75 ON prepared_spell (character_id)');
        $this->addSql('CREATE INDEX IDX_43E88820479EC90D ON prepared_spell (spell_id)');
        $this->addSql('CREATE INDEX IDX_43E88820EA000B10 ON prepared_spell (class_id)');
        $this->addSql('CREATE TABLE race (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, traits CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE ring (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shield (id INTEGER NOT NULL, ac INTEGER NOT NULL, maxDexterityBonus INTEGER NOT NULL, armorCheckPenalty INTEGER NOT NULL, arcaneSpellFailure INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shoulders (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(255) NOT NULL, untrained BOOLEAN NOT NULL, armorCheckPenalty BOOLEAN NOT NULL, keyAbility VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE spell (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, casting_time VARCHAR(255) NOT NULL, components VARCHAR(255) NOT NULL, range VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, saving_throw VARCHAR(255) NOT NULL, spell_resistance BOOLEAN NOT NULL, targets VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE spell_effect (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, caster_id INTEGER DEFAULT NULL, character_id INTEGER NOT NULL, spell_id INTEGER NOT NULL, caster_level SMALLINT NOT NULL, active BOOLEAN NOT NULL, name VARCHAR(255) DEFAULT NULL, passive BOOLEAN NOT NULL, effects CLOB DEFAULT NULL --(DC2Type:json)
        , conditions CLOB DEFAULT NULL --(DC2Type:json)
        , external_conditions CLOB DEFAULT NULL --(DC2Type:json)
        , prerequisities CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE INDEX IDX_EC166E7DB710083 ON spell_effect (caster_id)');
        $this->addSql('CREATE INDEX IDX_EC166E71136BE75 ON spell_effect (character_id)');
        $this->addSql('CREATE INDEX IDX_EC166E7479EC90D ON spell_effect (spell_id)');
        $this->addSql('CREATE TABLE sub_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, extra_spell_slot BOOLEAN DEFAULT \'0\' NOT NULL)');
        $this->addSql('CREATE INDEX IDX_10F7D26727ACA70 ON sub_class (parent_id)');
        $this->addSql('CREATE TABLE weapon (id INTEGER NOT NULL, category VARCHAR(255) NOT NULL, light BOOLEAN DEFAULT \'0\' NOT NULL, type VARCHAR(255) NOT NULL, two_handed BOOLEAN NOT NULL, range VARCHAR(255) DEFAULT NULL, damages VARCHAR(255) NOT NULL, critical_range SMALLINT DEFAULT NULL, critical SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE wrists (id INTEGER NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE abilities');
        $this->addSql('DROP TABLE armor');
        $this->addSql('DROP TABLE belt');
        $this->addSql('DROP TABLE body');
        $this->addSql('DROP TABLE character');
        $this->addSql('DROP TABLE character_spells');
        $this->addSql('DROP TABLE character_conditions');
        $this->addSql('DROP TABLE character_class_power');
        $this->addSql('DROP TABLE character_equipment');
        $this->addSql('DROP TABLE character_feat');
        $this->addSql('DROP TABLE chest');
        $this->addSql('DROP TABLE class_definition');
        $this->addSql('DROP TABLE class_skills');
        $this->addSql('DROP TABLE class_power');
        $this->addSql('DROP TABLE class_power_children');
        $this->addSql('DROP TABLE class_spell');
        $this->addSql('DROP TABLE condition');
        $this->addSql('DROP TABLE counter');
        $this->addSql('DROP TABLE eyes');
        $this->addSql('DROP TABLE feat');
        $this->addSql('DROP TABLE feet');
        $this->addSql('DROP TABLE hands');
        $this->addSql('DROP TABLE head');
        $this->addSql('DROP TABLE headband');
        $this->addSql('DROP TABLE inventory_items');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE ItemPowers');
        $this->addSql('DROP TABLE item_power');
        $this->addSql('DROP TABLE item_power_effect');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE levels_subclasses');
        $this->addSql('DROP TABLE levels_spells');
        $this->addSql('DROP TABLE level_skill');
        $this->addSql('DROP TABLE neck');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE power_effect');
        $this->addSql('DROP TABLE prepared_spell');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE ring');
        $this->addSql('DROP TABLE shield');
        $this->addSql('DROP TABLE shoulders');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE spell');
        $this->addSql('DROP TABLE spell_effect');
        $this->addSql('DROP TABLE sub_class');
        $this->addSql('DROP TABLE weapon');
        $this->addSql('DROP TABLE wrists');
    }
}
