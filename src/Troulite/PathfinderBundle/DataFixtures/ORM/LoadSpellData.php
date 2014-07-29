<?php

namespace Troulite\PathfinderBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Troulite\PathfinderBundle\Entity\Spell;

/**
 * Class LoadSpellData
 *
 * @package Troulite\PathfinderBundle\DataFixtures\ORM
 */
class LoadSpellData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @todo Speed bonus limited to 2 times c.speed
         */
        $spell = new Spell();
        $spell
            ->setName('Haste')
            ->setShortDescription('One creature/level moves faster, receives +1 on attack rolls, AC, and Reflex saves.')
            ->setLongDescription(
                "
                                The transmuted creatures move and act more quickly than normal. This extra speed has several effects.
                                When making a full attack action, a hasted creature may make one extra attack with one natural or manufactured weapon. The attack is made using the creature's full base attack bonus, plus any modifiers appropriate to the situation . (This effect is not cumulative with similar effects, such as that provided by a speed weapon, nor does it actually grant an extra action, so you can't use it to cast a second spell or otherwise take an extra action in the round.)
                                A hasted creature gains a +1 bonus on attack rolls and a +1 dodge bonus to AC and Reflex saves. Any condition that makes you lose your Dexterity bonus to Armor Class (if any) also makes you lose dodge bonuses.
                                All of the hasted creature's modes of movement(including land movement, burrow, climb, fly, and swim) increase by 30 feet, to a maximum of twice the subject's normal speed using that form of movement. This increase counts as an enhancement bonus, and it affects the creature's jumping distance as normal for increased speed . Multiple haste effects don't stack. Haste dispels and counters slow.
                            "
            )
            ->setCastingTime('1 standard action')
            ->setComponents('V, S, M (a shaving of licorice root)')
            ->setRange('5 + 1 /2 levels')
            ->setTargets('one creature/level, no two of which can be more than 30 ft. apart')
            ->setDuration('1 round/level')
            ->setSavingThrow('Fortitude negates (harmless)')
            ->setSpellResistance(true)
            ->setEffects(
                array(
                    'melee-attacks'      => ['type' => 'haste', 'value' => 1],
                    'ranged-attacks'     => ['type' => 'haste', 'value' => 1],
                    'melee-attack-roll'  => ['type' => 'haste', 'value' => 1],
                    'ranged-attack-roll' => ['type' => 'haste', 'value' => 1],
                    'ac'                 => ['type' => 'dodge', 'value' => 1],
                    'reflexes'           => ['type' => 'dodge', 'value' => 1],
                    'speed'              => ['type' => 'alteration', 'value' => 6]
                )
            )
            ->setPassive(true);
        $manager->persist($spell);
        $this->setReference('spell-haste', $spell);

        $spell = (new Spell())->setName("Acid Arrow")->setLongDescription(
            "An arrow of acid springs from your hand and speeds to its target. You must succeed on a ranged touch attack to hit your target. The arrow deals 2d4 points of acid damage with no splash damage. For every three caster levels you possess, the acid, unless neutralized, lasts for another round (to a maximum of 6 additional rounds at 18th level), dealing another 2d4 points of damage in each round."
        )->setCastingTime("1 standard action")->setComponents("rhubarb leaf and an adder's stomach & a dart")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 round + 1 round per three levels")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Acid Fog")->setLongDescription(
            "Acid fog creates a billowing mass of misty vapors like the <a href=\"Solid Fog\">solid fog</a> spell. In addition to slowing down creatures and obscuring sight, this spell's vapors are highly acidic. Each round on your turn, starting when you cast the spell, the fog deals 2d6 points of acid damage to each creature and object within it."
        )->setCastingTime("1 standard action")->setComponents("powdered peas and an animal hoof")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Acid Splash")->setLongDescription(
            "You fire a small orb of acid at the target. You must succeed on a ranged touch attack to hit your target. The orb deals 1d3 points of acid damage. This acid disappears after 1 round."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Aid")->setLongDescription(
            "Aid grants the target a +1 morale bonus on attack rolls and saves against fear effects, plus temporary hit points equal to 1d8 + caster level (to a maximum of 1d8+10 temporary hit points at caster level 10th)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("1 min./level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Air Walk")->setLongDescription(
            "The subject can tread on air as if walking on solid ground. Moving upward is similar to walking up a hill. The maximum upward or downward angle possible is 45 degrees, at a rate equal to half the air walker's normal speed. A strong wind (21+ miles per hour) can push the subject along or hold it back. At the end of a creature's turn each round, the wind blows the air walker 5 feet for each 5 miles per hour of wind speed. The creature may be subject to additional penalties in exceptionally strong or turbulent winds, such as loss of control over movement or physical damage from being buffeted about. Should the spell duration expire while the subject is still aloft, the magic fails slowly. The subject floats downward 60 feet per round for 1d6 rounds. If it reaches the ground in that amount of time, it lands safely. If not, it falls the rest of the distance, taking 1d6 points of damage per 10 feet of fall. Since dispelling a spell effectively ends it, the subject also descends in this way if the air walk spell is dispelled, but not if it is negated by an <a href=\"Antimagic Field\">antimagic field</a>. You can cast air walk on a specially trained mount so it can be ridden through the air. You can train a mount to move with the aid of air walk (counts as a trick; see Handle Animal skill) with 1 week of work and a DC 25 Handle Animal check."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature (Gargantuan or smaller) touched"
            )->setDuration("10 min./level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Alarm")->setLongDescription(
            "Alarm creates a subtle ward on an area you select. Once the spell effect is in place, it thereafter sounds a mental or audible alarm each time a creature of Tiny or larger size enters the warded area or touches it. A creature that speaks the password (determined by you at the time of casting) does not set off the alarm. You decide at the time of casting whether the alarm will be mental or audible in nature. Mental Alarm: A mental alarm alerts you (and only you) so long as you remain within 1 mile of the warded area. You note a single mental ping that awakens you from normal sleep but does not otherwise disturb concentration. A <a href=\"Silence\">silence</a> spell has no effect on a mental alarm. Audible Alarm: An audible alarm produces the sound of a hand bell, and anyone within 60 feet of the warded area can hear it clearly. Reduce the distance by 10 feet for each interposing closed door and by 20 feet for each substantial interposing wall. In quiet conditions, the ringing can be heard faintly as far as 180 feet away. The sound lasts for 1 round. Creatures within a <a href=\"Silence\">silence</a> spell cannot hear the ringing.  Ethereal or astral creatures do not trigger the alarm. Alarm can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents(
                "a tiny bell and a piece of very fine silver wire"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration(
                "2 hours/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Align Weapon")->setLongDescription(
            "Align weapon makes a weapon chaotic, evil, good, or lawful, as you choose. A weapon that is aligned can bypass the damage reduction of certain creatures. This spell has no effect on a weapon that already has an alignment.  You can't cast this spell on a natural weapon, such as an unarmed strike. When you make a weapon chaotic, evil, good, or lawful, align weapon is a chaotic, evil, good, or lawful spell, respectively."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "weapon touched or 50 projectiles (all of which must be together at the time of casting)"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Alter Self")->setLongDescription(
            "When you cast this spell, you can assume the form of any Small or Medium creature of the humanoid type. If the form you assume has any of the following abilities, you gain the listed ability: darkvision 60 feet, low-light vision, scent, and swim 30 feet. Small creature: If the form you take is that of a Small humanoid, you gain a +2 size bonus to your Dexterity. Medium creature: If the form you take is that of a Medium humanoid, you gain a +2 size bonus to your Strength."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Analyze Dweomer")->setLongDescription(
            "You can observe magical auras. Each round, you may examine a single creature or object that you can see as a free action. In the case of a magic item, you learn its functions (including any curse effects), how to activate its functions (if appropriate), and how many charges are left (if it uses charges). In the case of an object or creature with active spells cast upon it, you learn each spell, its effect, and its caster level. An attended object may attempt a Will save to resist this effect if its holder so desires. If the save succeeds, you learn nothing about the object except what you can discern by looking at it. An object that makes its save cannot be affected by any other analyze dweomer spells for 24 hours. Analyze dweomer does not function when used on an artifact."
        )->setCastingTime("1 standard action")->setComponents("a ruby and gold lens worth 1,500 gp")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one object or creature per caster level")->setDuration("1 round/level (D)")->setSavingThrow(
                "none or Will negates, see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animal Growth")->setLongDescription(
            "The target animal grows to twice its normal size and eight times its normal weight. This alteration changes the animal's size category to the next largest, grants it a +8 size bonus to Strength and a +4 size bonus to Constitution (and thus an extra 2 hit points per HD), and imposes a -2 size penalty to Dexterity. The creature's existing natural armor bonus increases by 2. The size change also affects the animal's modifier to AC, attack rolls, and its base damage. The animal's space and reach change as appropriate to the new size, but its speed does not change. If insufficient room is available for the desired growth, the creature attains the maximum possible size and may make a Strength check (using its increased Strength) to burst any enclosures in the process. If it fails, it is constrained without harm by the materials enclosing it--the spell cannot be used to crush a creature by increasing its size. All equipment worn or carried by the animal is similarly enlarged by the spell, though this change has no effect on the magical properties of any such equipment. Any enlarged item that leaves the enlarged creature's possession instantly returns to its normal size. The spell gives no means of command over an enlarged animal. Multiple magical effects that increase size do not stack."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one animal (Gargantuan or smaller)")->setDuration("1 min./level")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animal Messenger")->setLongDescription(
            "You compel a Tiny animal to go to a spot you designate. The most common use for this spell is to get an animal to carry a message to your allies. The animal cannot be one tamed or trained by someone else, including such creatures as familiars and animal companions. Using some type of food desirable to the animal as a lure, you call the animal to you. It advances and awaits your bidding. You can mentally impress on the animal a certain place well known to you or an obvious landmark. The directions must be simple, because the animal depends on your knowledge and can't find a destination on its own. You can attach a small item or note to the messenger. The animal then goes to the designated location and waits there until the duration of the spell expires, whereupon it resumes its normal activities. During this period of waiting, the messenger allows others to approach it and remove any scroll or token it carries. The intended recipient gains no special ability to communicate with the animal or read any attached message (if it's written in a language he doesn't know, for example)."
        )->setCastingTime("1 minute")->setComponents("a morsel of food the animal likes")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one Tiny animal")->setDuration("1 day/level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animal Shapes")->setLongDescription(
            "As <a href=\"Beast Shape III\">beast shape III</a>, except you change the form of up to one willing creature per caster level into an animal of your choice; the spell has no effect on unwilling creatures. All creatures must take the same kind of animal form. Recipients remain in the animal form until the spell expires or until you dismiss it for all recipients. In addition, an individual subject may choose to resume its normal form as a full-round action; doing so ends the spell for that subject alone."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("up to one willing creature per level, all within 30 ft. of each other.")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("none, see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animal Trance")->setLongDescription(
            "Your swaying motions and music (or singing, or chanting) compel animals and magical beasts to do nothing but watch you. Only a creature with an Intelligence score of 1 or 2 can be fascinated by this spell. Roll 2d6 to determine the total number of HD worth of creatures that you fascinate. The closest targets are selected first until no more targets within range can be affected."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("animals or magical beasts with Intelligence 1 or 2")->setDuration(
                "concentration"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animate Dead")->setLongDescription(
            "This spell turns corpses into undead skeletons or zombies that obey your spoken commands. The undead can be made to follow you, or they can be made to remain in an area and attack any creature (or just a specific kind of creature) entering the place. They remain animated until they are destroyed. A destroyed skeleton or zombie can't be animated again. Regardless of the type of undead you create with this spell, you can't create more HD of undead than twice your caster level with a single casting of animate dead. The <a href=\"Desecrate\">desecrate</a> spell doubles this limit. The undead you create remain under your control indefinitely. No matter how many times you use this spell, however, you can control only 4 HD worth of undead creatures per caster level. If you exceed this number, all the newly created creatures fall under your control, and any excess undead from previous castings become uncontrolled. You choose which creatures are released. Undead you control through the Command Undead feat do not count toward this limit. Skeletons: A skeleton can be created only from a mostly intact corpse or skeleton. The corpse must have bones. If a skeleton is made from a corpse, the flesh falls off the bones.  Zombies: A zombie can be created only from a mostly intact corpse. The corpse must be that of a creature with a physical anatomy."
        )->setCastingTime("1 standard action")->setComponents(
                "an onyx gem worth at least 25 gp per Hit Die of the undead"
            )->setRange("touch")->setTargets("one or more corpses touched")->setDuration(
                "instantaneous"
            )->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animate Objects")->setLongDescription(
            "You imbue inanimate objects with mobility and a semblance of life. Each such animated object then immediately attacks whomever or whatever you initially designate. An animated object can be of any nonmagical material. You may animate one Small or smaller object or a corresponding number of larger objects as follows: A Medium object counts as two Small or smaller objects, a Large object as four, a Huge object as eight, a Gargantuan object as 16, and a Colossal object as 32. You can change the designated target or targets as a move action, as if directing an active spell. This spell cannot affect objects carried or worn by a creature. Animate objects can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one Small object per caster level; see text")->setDuration("1 round/level")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animate Plants")->setLongDescription(
            "You imbue inanimate plants with mobility and a semblance of life. Each animated plant then immediately attacks whomever or whatever you initially designate as though it were an animated object of the appropriate size category. You may animate one Large or smaller plant, or a number of larger plants as follows: a Huge plant counts as two Large or smaller plants, a Gargantuan plant as four, and a Colossal plant as eight. You can change the designated target or targets as a move action, as if directing an active spell. Use the statistics for animated objects, except that plants smaller than Large don't have hardness. Animate plants cannot affect plant creatures, nor does it affect nonliving vegetable material. Entangle: Alternatively, you may imbue all plants within range with a degree of mobility, which allows them to entwine around creatures in the area. This usage of the spell duplicates the effect of an <a href=\"Entangle\">entangle</a> spell. Spell resistance does not keep creatures from being entangled. This effect lasts 1 hour per caster level."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one Large plant per three caster levels or all plants within range; see text")->setDuration(
                "1 round/level or 1 hour/level; see text"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Animate Rope")->setLongDescription(
            "You can animate a nonliving rope-like object. The maximum length assumes a rope with a 1-inch diameter. Reduce the maximum length by 50% for every additional inch of thickness, and increase it by 50% for each reduction of the rope's diameter by half. The possible commands are coil (form a neat, coiled stack), coil and knot,loop, loop and knot, tie and knot, and the opposites of all of the above (uncoil, and so forth). You can give one command each round as a move action, as if directing an active spell. The rope can enwrap only a creature or an object within 1 foot of it--it does not snake outward--so it must be thrown near the intended target. Doing so requires a successful ranged touch attack roll (range increment 10 feet). A typical 1-inch-diameter hemp rope has 2 hit points, AC 10, and requires a DC 23 Strength check to burst it. The rope does not deal damage, but it can be used as a trip line or to cause a single opponent that fails a Reflex saving throw to become entangled. A creature capable of spellcasting that is bound by this spell must make a concentration check with a DC of 15 + the spell's level to cast a spell. An entangled creature can slip free with a DC 20 Escape Artist check. The rope itself and any knots tied in it are not magical. The spell cannot affect objects carried or worn by a creature."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one rope-like object, length up to 50 ft. + 5 ft./level; see text")->setDuration(
                "1 round/level"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Antilife Shell")->setLongDescription(
            "You bring into being a mobile, hemispherical energy field that prevents the entrance of most types of living creatures. The effect hedges out animals, aberrations, dragons, fey, giants, humanoids, magical beasts, monstrous humanoids, oozes, plants, and vermin, but not constructs, elementals, outsiders, or undead. This spell may be used only defensively, not aggressively. Forcing an abjuration barrier against creatures that the spell keeps at bay collapses the barrier."
        )->setCastingTime("1 round")->setComponents("")->setRange("10 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Antimagic Field")->setLongDescription(
            "An invisible barrier surrounds you and moves with you. The space within this barrier is impervious to most magical effects, including spells, spell-like abilities, and supernatural abilities. Likewise, it prevents the functioning of any magic items or spells within its confines. An antimagic field suppresses any spell or magical effect used within, brought into, or cast into the area, but does not dispel it. Time spent within an antimagic field counts against the suppressed spell's duration. Summoned creatures of any type and incorporeal undead wink out if they enter an antimagic field. They reappear in the same spot once the field goes away. Time spent winked out counts normally against the duration of the conjuration that is maintaining the creature. If you cast antimagic field in an area occupied by a summoned creature that has spell resistance, you must make a caster level check (1d20 + caster level) against the creature's spell resistance to make it wink out. (The effects of instantaneous conjurations are not affected by an antimagic field because the conjuration itself is no longer in effect, only its result.) A normal creature can enter the area, as can normal missiles. Furthermore, while a magic sword does not function magically within the area, it is still a sword (and a masterwork sword at that). The spell has no effect on golems and other constructs that are imbued with magic during their creation process and are thereafter self-supporting (unless they have been summoned, in which case they are treated like any other summoned creatures). Elementals, corporeal undead, and outsiders are likewise unaffected unless summoned. These creatures' spell-like or supernatural abilities may be temporarily nullified by the field. <a href=\"Dispel Magic\">Dispel magic</a> does not remove the field. Two or more antimagic fields sharing any of the same space have no effect on each other. Certain spells, such as <a href=\"Wall of Force\">wall of force</a>, <a href=\"Prismatic Sphere\">prismatic sphere</a>, and <a href=\"Prismatic Wall\">prismatic wall</a>, remain unaffected by antimagic field. Artifacts and deities are unaffected by mortal magic such as this.  Should a creature be larger than the area enclosed by the barrier, any part of it that lies outside the barrier is unaffected by the field."
        )->setCastingTime("1 standard action")->setComponents("pinch of powdered iron or iron filings")->setRange(
                "10 ft."
            )->setTargets("")->setDuration("10 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Antipathy")->setLongDescription(
            "You cause an object or location to emanate magical vibrations that repel either a specific kind of intelligent creature or creatures of a particular alignment, as defined by you. The kind of creature to be affected must be named specifically. A creature subtype is not specific enough. Likewise, the specific alignment to be repelled must be named. Creatures of the designated kind or alignment feel an urge to leave the area or to avoid the affected item. A compulsion forces them to abandon the area or item, shunning it and never willingly returning to it while the spell is in effect. A creature that makes a successful saving throw can stay in the area or touch the item but feels uncomfortable doing so. This distracting discomfort reduces the creature's Dexterity score by 4 points. Antipathy counters and dispels <a href=\"Sympathy\">sympathy</a>."
        )->setCastingTime("1 hour")->setComponents("a lump of alum soaked in vinegar")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one location (up to a 10-ft. cube/level) or one object")->setDuration(
                "2 hours/level (D)"
            )->setSavingThrow("Will partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Antiplant Shell")->setLongDescription(
            "The antiplant shell spell creates an invisible, mobile barrier that keeps all creatures within the shell protected from attacks by plant creatures or animated plants. As with many abjuration spells, forcing the barrier against creatures that the spell keeps at bay strains and collapses the field."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("10 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Arcane Eye")->setLongDescription(
            "You create an invisible magical sensor that sends you visual information. You can create the arcane eye at any point you can see, but it can then travel outside your line of sight without hindrance. An arcane eye travels at 30 feet per round (300 feet per minute) if viewing an area ahead as a human would (primarily looking at the floor) or 10 feet per round (100 feet per minute) if examining the ceiling and walls as well as the floor ahead. It sees exactly as you would see if you were there. The eye can travel in any direction as long as the spell lasts. Solid barriers block its passage, but it can pass through a hole or space as small as 1 inch in diameter. The eye can't enter another plane of existence, even through a gate or similar magical portal. You must concentrate to use an arcane eye. If you do not concentrate, the eye is inert until you again concentrate."
        )->setCastingTime("10 minutes")->setComponents("a bit of bat fur")->setRange("unlimited")->setTargets(
                ""
            )->setDuration("1 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Arcane Lock")->setLongDescription(
            "An arcane lock spell cast upon a door, chest, or portal magically locks it. You can freely pass your own arcane lock without affecting it. If the locked object has a lock, the DC to open that lock increases by 10 while it remains attached to the object. If the object does not have a lock, this spell creates one that can only be opened with a DC 20 Disable Device skill check. A door or object secured with this spell can be opened only by breaking in or with a successful <a href=\"Dispel Magic\">dispel magic</a> or <a href=\"Knock\">knock</a> spell. Add 10 to the normal DC to break open a door or portal affected by this spell. A <a href=\"Knock\">knock</a> spell does not remove an arcane lock; it only suppresses the effect for 10 minutes."
        )->setCastingTime("1 standard action")->setComponents("gold dust worth 25 gp")->setRange("touch")->setTargets(
                "door, chest, or portal touched, up to 30 sq. ft./level in size"
            )->setDuration("permanent")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Arcane Mark")->setLongDescription(
            "This spell allows you to inscribe your personal rune or mark, which can consist of no more than six characters. The writing can be visible or invisible. An arcane mark spell enables you to etch the rune upon any substance without harm to the material upon which it is placed. If an invisible mark is made, a <a href=\"Detect Magic\">detect magic</a> spell causes it to glow and be visible, though not necessarily understandable. See <a href=\"Invisibility\">invisibility</a>, <a href=\"True Seeing\">true seeing</a>, a gem of seeing, or a robe of eyes likewise allows the user to see an invisible arcane mark. A <a href=\"Read Magic\">read magic</a> spell reveals the words, if any. The mark cannot be dispelled, but it can be removed by the caster or by an <a href=\"Erase\">erase</a> spell. If an arcane mark is placed on a living being, the effect gradually fades in about a month. Arcane mark must be cast on an object prior to casting <a href=\"Instant Summons\">instant summons</a> on the same object (see that spell description for details)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets("")->setDuration(
                "permanent"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Arcane Sight")->setLongDescription(
            "This spell makes your eyes glow blue and allows you to see magical auras within 120 feet of you. The effect is similar to that of a <a href=\"Detect Magic\">detect magic</a> spell, but arcane sight does not require concentration and discerns aura location and power more quickly. You know the location and power of all magical auras within your sight. An aura's power depends on a spell's functioning level or an item's caster level, as noted in the description of the <a href=\"Detect Magic\">detect magic</a> spell. If the items or creatures bearing the auras are in line of sight, you can make Spellcraft skill checks to determine the school of magic involved in each. (Make one check per aura; DC 15 + spell level, or 15 + half caster level for a nonspell effect.) If you concentrate on a specific creature within 120 feet of you as a standard action, you can determine whether it has any spellcasting or spell-like abilities, whether these are arcane or divine (spell-like abilities register as arcane), and the strength of the most powerful spell or spell-like ability the creature currently has available for use. As with <a href=\"Detect Magic\">detect magic</a>, you can use this spell to identify the properties of magic items, but not artifacts. Arcane sight can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Arcane Sight, Greater")->setLongDescription(
            "This spell functions like <a href=\"Arcane Sight\">arcane sight</a>, except that you automatically know which spells or magical effects are active upon any individual or object you see. Unlike <a href=\"Arcane Sight\">arcane sight</a>, this spell cannot be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Astral Projection")->setLongDescription(
            "By freeing your spirit from your physical body, this spell allows you to project an astral body onto another plane altogether. You can bring the astral forms of other willing creatures with you, provided that these subjects are linked in a circle with you at the time of the casting. These fellow travelers are dependent upon you and must accompany you at all times. If something happens to you during the journey, your companions are stranded wherever you left them. You project your astral self onto the Astral Plane, leaving your physical body behind on the Material Plane in a state of suspended animation. The spell projects an astral copy of you and all you wear or carry onto the Astral Plane. Since the Astral Plane touches upon other planes, you can travel astrally to any of these other planes as you will. To enter one, you leave the Astral Plane, forming a new physical body (and equipment) on the plane of existence you have chosen to enter. While you are on the Astral Plane, your astral body is connected at all times to your physical body by an incorporeal silver cord. If the cord is broken, you are killed, astrally and physically. Luckily, very few things can destroy a silver cord. When a second body is formed on a different plane, the silver cord remains invisibly attached to the new body. If the second body or the astral form is slain, the cord simply returns to your body where it rests on the Material Plane, thereby reviving it from its state of suspended animation. This is a traumatic affair, however, and you gain two permanent negative levels if your second body or astral form is slain. Although astral projections are able to function on the Astral Plane, their actions affect only creatures existing on the Astral Plane; a physical body must be materialized on other planes. You and your companions may travel through the Astral Plane indefinitely. Your bodies simply wait behind in a state of suspended animation until you choose to return your spirits to them. The spell lasts until you desire to end it, or until it is terminated by some outside means, such as <a href=\"Dispel Magic\">dispel magic</a> cast upon either the physical body or the astral form, the breaking of the silver cord, or the destruction of your body back on the Material Plane (which kills you). When this spell ends, your astral body and all of its gear, vanishes."
        )->setCastingTime("30 minutes")->setComponents("1,000 gp jacinth")->setRange("touch")->setTargets(
                "you plus one additional willing creature touched per two caster levels"
            )->setDuration("see text")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Atonement")->setLongDescription(
            "This spell removes the burden of misdeeds from the subject. The creature seeking atonement must be truly repentant and desirous of setting right its misdeeds. If the atoning creature committed the evil act unwittingly or under some form of compulsion, atonement operates normally at no cost to you. However, in the case of a creature atoning for deliberate misdeeds, you must intercede with your deity (requiring you to expend 2,500 gp in rare incense and offerings). Atonement may be cast for one of several purposes, depending on the version selected. Reverse Magical Alignment Change: If a creature has had its alignment magically changed, atonement returns its alignment to its original status at no additional cost. Restore Class: A paladin, or other class, who has lost her class features due to violating the alignment restrictions of her class may have her class features restored by this spell.  Restore Cleric or Druid Spell Powers: A cleric or druid who has lost the ability to cast spells by incurring the anger of her deity may regain that ability by seeking atonement from another cleric of the same deity or another druid. If the transgression was intentional, the casting cleric must expend 2,500 gp in rare incense and offerings for her god's intercession. Redemption or Temptation: You may cast this spell upon a creature of an opposing alignment in order to offer it a chance to change its alignment to match yours. The prospective subject must be present for the entire casting process. Upon completion of the spell, the subject freely chooses whether it retains its original alignment or acquiesces to your offer and changes to your alignment. No duress, compulsion, or magical influence can force the subject to take advantage of the opportunity offered if it is unwilling to abandon its old alignment. This use of the spell does not work on outsiders or any creature incapable of changing its alignment naturally. Though the spell description refers to evil acts, atonement can be used on any creature that has performed acts against its alignment, regardless of the actual alignment in question. Note: Normally, changing alignment is up to the player. This use of atonement offers a method for a character to change his or her alignment drastically, suddenly, and definitively."
        )->setCastingTime("1 hour")->setComponents(
                "burning incense & a set of prayer beads or other prayer device worth at least 500 gp"
            )->setRange("touch")->setTargets("living creature touched")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Augury")->setLongDescription(
            "An augury can tell you whether a particular action will bring good or bad results for you in the immediate future. The base chance for receiving a meaningful reply is 70% + 1% per caster level, to a maximum of 90%; this roll is made secretly. A question may be so straightforward that a successful result is automatic, or so vague as to have no chance of success. If the augury succeeds, you get one of four results: * Weal (if the action will probably bring good results). * Woe (for bad results). * Weal and woe (for both). * Nothing (for actions that don't have especially good or bad results). If the spell fails, you get the nothing result. A cleric who gets the nothing result has no way to tell whether it was the consequence of a failed or successful augury. The augury can see into the future only about half an hour, so anything that might happen after that does not affect the result. Thus, the result might not take into account the long-term consequences of a contemplated action. All auguries cast by the same person about the same topic use the same die result as the first casting."
        )->setCastingTime("1 minute")->setComponents(
                "incense worth at least 25 gp & a set of marked sticks or bones worth at least 25 gp"
            )->setRange("personal")->setTargets("you")->setDuration("instantaneous")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Awaken")->setLongDescription(
            "You awaken a tree or animal to human-like sentience. To succeed, you must make a Will save (DC 10 + the animal's current HD, or the HD the tree will have once awakened). The awakened animal or tree is friendly toward you. You have no special empathy or connection with a creature you awaken, although it serves you in specific tasks or endeavors if you communicate your desires to it. If you cast awaken again, any previously awakened creatures remain friendly to you, but they no longer undertake tasks for you unless it is in their best interests. An awakened tree has characteristics as if it were an animated object, except that it gains the plant type and its Intelligence, Wisdom, and Charisma scores are each 3d6. An awakened plant gains the ability to move its limbs, roots, vines, creepers, and so forth, and it has senses similar to a human's. An awakened animal gets 3d6 Intelligence, +1d3 Charisma, and +2 HD. Its type becomes magical beast (augmented animal). An awakened animal can't serve as an animal companion, familiar, or special mount.  An awakened tree or animal can speak one language that you know, plus one additional language that you know per point of Intelligence bonus (if any). This spell does not function on an animal or plant with an Intelligence greater than 2."
        )->setCastingTime("24 hours")->setComponents("herbs and oils worth 2,000 gp")->setRange("touch")->setTargets(
                "animal or tree touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Baleful Polymorph")->setLongDescription(
            "As <a href=\"Beast Shape III\">beast shape III</a>, except that you change the subject into a Small or smaller animal of no more than 1 HD. If the new form would prove fatal to the creature, such as an aquatic creature not in water, the subject gets a +4 bonus on the save. If the spell succeeds, the subject must also make a Will save. If this second save fails, the creature loses its extraordinary, supernatural, and spell-like abilities, loses its ability to cast spells (if it had the ability), and gains the alignment, special abilities, and Intelligence, Wisdom, and Charisma scores of its new form in place of its own. It still retains its class and level (or HD), as well as all benefits deriving therefrom (such as base attack bonus, base save bonuses, and hit points). It retains any class features (other than spellcasting) that aren't extraordinary, supernatural, or spell-like abilities. Any polymorph effects on the target are automatically dispelled when a target fails to resist the effects of baleful polymorph, and as long as baleful polymorph remains in effect, the target cannot use other <a href=\"Polymorph\">polymorph</a> spells or effects to assume a new form. Incorporeal or gaseous creatures are immune to baleful polymorph, and a creature with the shapechanger subtype can revert to its natural form as a standard action."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature")->setDuration("permanent")->setSavingThrow(
                ": Fortitude negates, Will partial, see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bane")->setLongDescription(
            "Bane fills your enemies with fear and doubt. Each affected creature takes a -1 penalty on attack rolls and a -1 penalty on saving throws against fear effects. Bane counters and dispels <a href=\"Bless\">bless</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("50 ft.")->setTargets("")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Banishment")->setLongDescription(
            "A banishment spell is a more powerful version of the <a href=\"Dismissal\">dismissal</a> spell. It enables you to force extraplanar creatures out of your home plane. As many as 2 Hit Dice of creatures per caster level can be banished. You can improve the spell's chance of success by presenting at least one object or substance that the target hates, fears, or otherwise opposes. For each such object or substance, you gain a +1 bonus on your caster level check to overcome the target's spell resistance (if any), and the saving throw DC increases by 2.  Certain rare items might work twice as well as a normal item for the purpose of the bonuses (each providing a +2 bonus on the caster level check against spell resistance and increasing the save DC by 4)."
        )->setCastingTime("1 standard action")->setComponents("see text")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "one or more extraplanar creatures, no two of which can be more than 30 ft. apart"
            )->setDuration(
                "instantaneous"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Barkskin")->setLongDescription(
            "Barkskin toughens a creature's skin. The effect grants a +2 enhancement bonus to the creature's existing natural armor bonus. This enhancement bonus increases by 1 for every three caster levels above 3rd, to a maximum of +5 at 12th level. The enhancement bonus provided by barkskin stacks with the target's natural armor bonus, but not with other enhancement bonuses to natural armor. A creature without natural armor has an effective natural armor bonus of +0."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("10 min./level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bear's Endurance")->setLongDescription(
            "The affected creature gains greater vitality and stamina. The spell grants the subject a +4 enhancement bonus to Constitution, which adds the usual benefits to hit points, Fortitude saves, Constitution checks, and so forth. Hit points gained by a temporary increase in Constitution score are not temporary hit points. They go away when the subject's Constitution drops back to normal. They are not lost first as temporary hit points are."
        )->setCastingTime("1 standard action")->setComponents("a few hairs, or a pinch of dung, from a bear")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bear's Endurance, Mass")->setLongDescription(
            "Mass bear's endurance works like <a href=\"Bear's Endurance\">bear's endurance</a>, except that it affects multiple creatures."
        )->setCastingTime("1 standard action")->setComponents("a few hairs, or a pinch of dung, from a bear")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Beast Shape 1")->setLongDescription(
            "When you cast this spell, you can assume the form of any Small or Medium creature of the animal type. If the form you assume has any of the following abilities, you gain the listed ability: climb 30 feet, fly 30 feet (average maneuverability), swim 30 feet, darkvision 60 feet, low-light vision, and scent. Small animal: If the form you take is that of a Small animal, you gain a +2 size bonus to your Dexterity and a +1 natural armor bonus. Medium animal: If the form you take is that of a Medium animal, you gain a +2 size bonus to your Strength and a +2 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Beast Shape 2")->setLongDescription(
            "This spell functions as <a href=\"Beast Shape I\">beast shape I</a>, except that it also allows you to assume the form of a Tiny or Large creature of the animal type. If the form you assume has any of the following abilities, you gain the listed ability: climb 60 feet, fly 60 feet (good maneuverability), swim 60 feet, darkvision 60 feet, low-light vision, scent, grab, pounce, and trip. Tiny animal: If the form you take is that of a Tiny animal, you gain a +4 size bonus to your Dexterity, a -2 penalty to your Strength, and a +1 natural armor bonus. Large animal: If the form you take is that of a Large animal, you gain a +4 size bonus to your Strength, a -2 penalty to your Dexterity, and a +4 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Beast Shape 3")->setLongDescription(
            "This spell functions as <a href=\"Beast Shape II\">beast shape II</a>, except that it also allows you to assume the form of a Diminutive or Huge creature of the animal type. This spell also allows you to take on the form of a Small or Medium creature of the magical beast type. If the form you assume has any of the following abilities, you gain the listed ability: burrow 30 feet, climb 90 feet, fly 90 feet (good maneuverability), swim 90 feet, blindsense 30 feet, darkvision 60 feet, low-light vision, scent, constrict, ferocity, grab, jet, poison, pounce, rake, trample, trip, and web. Diminutive animal: If the form you take is that of a Diminutive animal, you gain a +6 size bonus to your Dexterity, a -4 penalty to your Strength, and a +1 natural armor bonus. Huge animal: If the form you take is that of a Huge animal, you gain a +6 size bonus to your Strength, a -4 penalty to your Dexterity, and a +6 natural armor bonus. Small magical beast: If the form you take is that of a Small magical beast, you gain a +4 size bonus to your Dexterity, and a +2 natural armor bonus. Medium magical beast: If the form you take is that of a Medium magical beast, you gain a +4 size bonus to your Strength, and a +4 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Beast Shape 4")->setLongDescription(
            "This spell functions as <a href=\"Beast Shape III\">beast shape III</a> except that it also allows you to assume the form of a Tiny or Large creature of the magical beast type. If the form you assume has any of the following abilities, you gain the listed ability: burrow 60 feet, climb 90 feet, fly 120 feet (good maneuverability), swim 120 feet, blindsense 60 feet, darkvision 90 feet, low-light vision, scent, tremorsense 60 feet, breath weapon, constrict, ferocity, grab, jet, poison, pounce, rake, rend, roar, spikes, trample, trip, and web. If the creature has immunity or resistance to any elements, you gain resistance 20 to those elements. If the creature has vulnerability to an element, you gain that vulnerability. Tiny magical beast: If the form you take is that of a Tiny magical beast, you gain a -2 penalty to your Strength, a +8 size bonus to your Dexterity, and a +3 natural armor bonus. Large magical beast: If the form you take is that of a Large magical beast, you gain a +6 size bonus to your Strength, a -2 penalty on your Dexterity, a +2 size bonus to your Constitution, and a +6 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bestow Curse")->setLongDescription(
            "You place a curse on the subject. Choose one of the following. * -6 decrease to an ability score (minimum 1). * -4 penalty on attack rolls, saves, ability checks, and skill checks. * Each turn, the target has a 50% chance to act normally; otherwise, it takes no action. You may also invent your own curse, but it should be no more powerful than those described above. The curse bestowed by this spell cannot be dispelled, but it can be removed with a <a href=\"Break Enchantment\">break enchantment</a>, <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, <a href=\"Remove Curse\">remove curse</a>, or <a href=\"Wish\">wish</a> spell. Bestow curse counters <a href=\"Remove Curse\">remove curse</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("permanent")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Binding")->setLongDescription(
            "A binding spell creates a magical restraint to hold a creature. The target gets an initial saving throw only if its Hit Dice equal at least half your caster level. You may have as many as six assistants help you with the spell. For each assistant who casts <a href=\"Suggestion\">suggestion</a>, your caster level for this casting of binding increases by 1. For each assistant who casts <a href=\"Dominate Animal\">dominate animal</a>, <a href=\"Dominate Person\">dominate person</a>, or <a href=\"Dominate Monster\">dominate monster</a>, your caster level for this casting of binding increases by a number equal to a third of that assistant's level, provided that the spell's target is appropriate for a binding spell. Since the assistants' spells are cast simply to improve your caster level for the purpose of the binding spell, saving throws and spell resistance against the assistants' spells are irrelevant. Your caster level determines whether the target gets an initial Will saving throw and how long the binding lasts. All binding spells are dismissible. Regardless of the version of binding you cast, you can specify triggering conditions that end the spell and release the creature whenever they occur. These triggers can be as simple or elaborate as you desire, but the condition must be reasonable and have a likelihood of coming to pass. The conditions can be based on a creature's name, identity, or alignment, but otherwise must be based on observable actions or qualities. Intangibles such as level, class, Hit Dice, or hit points don't qualify. Once the spell is cast, its triggering conditions cannot be changed. Setting a release condition increases the save DC (assuming a saving throw is allowed) by 2. If you cast any of the first three versions of binding (those with limited durations), you may cast additional binding spells to prolong the effect, overlapping the durations. If you do so, the target gets a saving throw at the end of the first spell's duration, even if your caster level was high enough to disallow an initial saving throw. If the creature's save succeeds, all binding spells it has received are broken. The binding spell has six versions. Choose one of the following versions when you cast the spell. Chaining: The subject is confined by restraints that generate an <a href=\"Antipathy\">antipathy</a> spell affecting all creatures who approach the subject, except you. The duration is 1 year per caster level. The subject of this form of binding is confined to the spot it occupied when it received the spell. Casting this version requires a chain that is long enough to wrap around the creature three times. Slumber: This version causes the subject to become comatose for as long as 1 year per caster level. The subject does not need to eat or drink while slumbering, nor does it age. This form of binding is slightly easier to resist. Reduce the spell's save DC by 1. Casting this version requires a jar of sand or rose petals. This is a sleep effect. Bound Slumber: This combination of chaining and slumber lasts for as long as 1 month per caster level. Reduce the save DC by 2. Casting this version requires both a long chain and a jar of sand or rose petals. This is a sleep effect. Hedged Prison: The subject is transported to or otherwise brought within a confined area from which it cannot wander by any means. This effect is permanent. Reduce the save DC by 3. Casting this version requires a tiny golden cage worth 100 gp that is consumed when the spell is cast. Metamorphosis: The subject assumes <a href=\"Gaseous Form\">gaseous form</a>, except for its head or face. It is held harmless in a jar or other container, which may be transparent if you so choose. The creature remains aware of its surroundings and can speak, but it cannot leave the container, attack, or use any of its powers or abilities. The binding is permanent. The subject does not need to breathe, eat, or drink while metamorphosed, nor does it age. Reduce the save DC by 4. Minimus Containment: The subject is shrunk to a height of 1 inch or less and held within some gem, jar, or similar object. The binding is permanent. The subject does not need to breathe, eat, or drink while contained, nor does it age. Reduce the save DC by 4. You can't dispel a binding spell with <a href=\"Dispel Magic\">dispel magic</a> or a similar effect, though an <a href=\"Antimagic Field\">antimagic field</a> or <a href=\"Mage's Disjunction\">mage's disjunction</a> affects it normally. A bound extraplanar creature cannot be sent back to its home plane by <a href=\"Dismissal\">dismissal</a>, <a href=\"Banishment\">banishment</a>, or a similar effect."
        )->setCastingTime("1 minute")->setComponents(
                "opals worth 500 gp per HD of the target creature, plus other components as specified below"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("one living creature")->setDuration(
                "see text (D)"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Black Tentacles")->setLongDescription(
            "This spell causes a field of rubbery black tentacles to appear, burrowing up from the floor and reaching for any creature in the area.  Every creature within the area of the spell is the target of a combat maneuver check made to grapple each round at the beginning of your turn, including the round that black tentacles is cast. Creatures that enter the area of effect are also automatically attacked. The tentacles do not provoke attacks of opportunity. When determining the tentacles' CMB, the tentacles use your caster level as their base attack bonus and receive a +4 bonus due to their Strength and a +1 size bonus. Roll only once for the entire spell effect each round and apply the result to all creatures in the area of effect. If the tentacles succeed in grappling a foe, that foe takes 1d6+4 points of damage and gains the grappled condition. Grappled opponents cannot move without first breaking the grapple. All other movement is prohibited unless the creature breaks the grapple first. The black tentacles spell receives a +5 bonus on grapple checks made against opponents it is already grappling, but cannot move foes or pin foes. Each round that black tentacles succeeds on a grapple check, it deals an additional 1d6+4 points of damage. The CMD of black tentacles, for the purposes of escaping the grapple, is equal to 10 + its CMB. The tentacles created by this spell cannot be damaged, but they can be dispelled as normal. The entire area of effect is considered difficult terrain while the tentacles last."
        )->setCastingTime("1 standard action")->setComponents("octopus or squid tentacle")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow(": none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Blade Barrier")->setLongDescription(
            "An immobile, vertical curtain of whirling blades shaped of pure force springs into existence. Any creature passing through the wall takes 1d6 points of damage per caster level (maximum 15d6), with a Reflex save for half damage. If you evoke the barrier so that it appears where creatures are, each creature takes damage as if passing through the wall. Each such creature can avoid the wall (ending up on the side of its choice) and thus take no damage by making a successful Reflex save. A blade barrier provides cover (+4 bonus to AC, +2 bonus on Reflex saves) against attacks made through it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow(
                "Reflex half or Reflex negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Blasphemy")->setLongDescription(
            "Any nonevil creature within the area of a blasphemy spell suffers the following ill effects. <table><tr><th>HD</th><th>Effect</th></tr><tr><td>Equal to caster level</td><td>Dazed</td></tr><tr class=\"alt\"><td>Up to caster level -1</td><td>Weakened, dazed</td></tr><tr><td>Up to caster level -5</td><td>Paralyzed, weakened, dazed</td></tr><tr class=\"alt\"><td>Up to caster level -10</td><td>Killed, paralyzed, weakened, dazed</td></tr></table> The effects are cumulative and concurrent. A successful Will save reduces or eliminates these effects. Creatures affected by multiple effects make only one save and apply the result to all the effects. Dazed: The creature can take no actions for 1 round, though it defends itself normally. Save negates. Weakened: The creature's Strength score decreases by 2d6 points for 2d4 rounds. Save for half. Paralyzed: The creature is paralyzed and helpless for 1d10 minutes. Save reduces the paralyzed effect to 1 round. Killed: Living creatures die. Undead creatures are destroyed. Save negates. If the save is successful, the creature instead takes 3d6 points of damage + 1 point per caster level (maximum +25). Furthermore, if you are on your home plane when you cast this spell, nonevil extraplanar creatures within the area are instantly banished back to their home planes. Creatures so banished cannot return for at least 24 hours. This effect takes place regardless of whether the creatures hear the blasphemy or not. The <a href=\"Banishment\">banishment</a> effect allows a Will save (at a -4 penalty) to negate. Creatures whose Hit Dice exceed your caster level are unaffected by blasphemy."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("40 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bleed")->setLongDescription(
            "You cause a living creature that is below 0 hit points but stabilized to resume dying. Upon casting this spell, you target a living creature that has -1 or fewer hit points. That creature begins dying, taking 1 point of damage per round. The creature can be stabilized later normally. This spell causes a creature that is dying to take 1 point of damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("instantaneous")->setSavingThrow(
                ": Will negates"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bless")->setLongDescription(
            "Bless fills your allies with courage. Each ally gains a +1 morale bonus on attack rolls and on saving throws against fear effects. Bless counters and dispels <a href=\"Bane\">bane</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("50 ft.")->setTargets("")->setDuration(
                "1 min./level"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bless Water")->setLongDescription(
            "This transmutation imbues a flask (1 pint) of water with positive energy, turning it into holy water."
        )->setCastingTime("1 minute")->setComponents("5 pounds of powdered silver worth 25 gp")->setRange(
                "touch"
            )->setTargets("flask of water touched")->setDuration("instantaneous")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bless Weapon")->setLongDescription(
            "This transmutation makes a weapon strike true against evil foes. The weapon is treated as having a +1 enhancement bonus for the purpose of bypassing the DR of evil creatures or striking evil incorporeal creatures (though the spell doesn't grant an actual enhancement bonus). The weapon also becomes good-aligned, which means it can bypass the DR of certain creatures. (This effect overrides and suppresses any other alignment the weapon might have.) Individual arrows or bolts can be transmuted, but affected projectile weapons (such as bows) don't confer the benefit to the projectiles they shoot. In addition, all critical hit rolls against evil foes are automatically successful, so every threat is a critical hit. This last effect does not apply to any weapon that already has a magical effect related to critical hits, such as a keen weapon or a vorpal sword."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "weapon touched"
            )->setDuration("1 min./level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Blight")->setLongDescription(
            "This spell withers a single plant of any size. An affected plant creature takes 1d6 points of damage per level (maximum 15d6) and may attempt a Fortitude saving throw for half damage. A plant that isn't a creature doesn't receive a save and immediately withers and dies. This spell has no effect on the soil or surrounding plant life."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("Fortitude half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Blindness/Deafness")->setLongDescription(
            "You call upon the powers of unlife to render the subject blinded or deafened, as you choose."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one living creature")->setDuration("permanent (D)")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Blink")->setLongDescription(
            "You blink quickly back and forth between the Material Plane and the Ethereal Plane and look as though you're winking in and out of reality at random. Blink has several effects, as follows. Physical attacks against you have a 50% miss chance, and the Blind-Fight feat doesn't help opponents, since you're ethereal and not merely invisible. If the attack is capable of striking ethereal creatures, the miss chance is only 20% (for concealment). If the attacker can see invisible creatures, the miss chance is also only 20%. (For an attacker who can both see and strike ethereal creatures, there is no miss chance.) Likewise, your own attacks have a 20% miss chance, since you sometimes go ethereal just as you are about to strike. Any individually targeted spell has a 50% chance to fail against you while you're blinking unless your attacker can target invisible, ethereal creatures. Your own spells have a 20% chance to activate just as you go ethereal, in which case they typically do not affect the Material Plane (but they might affect targets on the Ethereal Plane). While blinking, you take only half damage from area attacks (but full damage from those that extend onto the Ethereal Plane). Although you are only partially visible, you are not considered invisible and targets retain their Dexterity bonus to AC against your attacks. You do receive a +2 bonus on attack rolls made against enemies that cannot see invisible creatures. You take only half damage from falling, since you fall only while you are material. While blinking, you can step through (but not see through) solid objects. For each 5 feet of solid material you walk through, there is a 50% chance that you become material. If this occurs, you are shunted off to the nearest open space and take 1d6 points of damage per 5 feet so traveled. Since you spend about half your time on the Ethereal Plane, you can see and even attack ethereal creatures. You interact with ethereal creatures roughly the same way you interact with material ones. An ethereal creature is invisible, incorporeal, and capable of moving in any direction, even up or down. As an incorporeal creature, you can move through solid objects, including living creatures. An ethereal creature can see and hear the Material Plane, but everything looks gray and insubstantial. Sight and hearing on the Material Plane are limited to 60 feet. Force effects and abjurations affect you normally. Their effects extend onto the Ethereal Plane from the Material Plane, but not vice versa. An ethereal creature can't attack material creatures, and spells you cast while ethereal affect only other ethereal things. Certain material creatures or objects have attacks or effects that work on the Ethereal Plane. Treat other ethereal creatures and objects as material."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Blur")->setLongDescription(
            "The subject's outline appears blurred, shifting, and wavering. This distortion grants the subject concealment (20% miss chance). A see <a href=\"Invisibility\">invisibility</a> spell does not counteract the blur effect, but a <a href=\"True Seeing\">true seeing</a> spell does. Opponents that cannot see the subject ignore the spell's effect (though fighting an unseen opponent carries penalties of its own)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Break Enchantment")->setLongDescription(
            "This spell frees victims from enchantments, transmutations, and curses. Break enchantment can reverse even an instantaneous effect. For each such effect, you make a caster level check (1d20 + caster level, maximum +15) against a DC of 11 + caster level of the effect. Success means that the creature is free of the spell, curse, or effect. For a cursed magic item, the DC is equal to the DC of the curse. If the spell is one that cannot be dispelled by <a href=\"Dispel Magic\">dispel magic</a>, break enchantment works only if that spell is 5th level or lower.  If the effect comes from a permanent magic item, break enchantment does not remove the curse from the item, but it does free the victim from the item's effects. "
        )->setCastingTime("1 minute")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                "up to one creature per level, all within 30 ft. of each other"
            )->setDuration("instantaneous")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Breath of Life")->setLongDescription(
            "This spell cures 5d8 points of damage + 1 point per caster level (maximum +25).  Unlike other spells that heal damage, breath of life can bring recently slain creatures back to life. If cast upon a creature that has died within 1 round, apply the healing from this spell to the creature. If the healed creature's hit point total is at a negative amount less than its Constitution score, it comes back to life and stabilizes at its new hit point total. If the creature's hit point total is at a negative amount equal to or greater than its Constitution score, the creature remains dead. Creatures brought back to life through breath of life gain a temporary negative level that lasts for 1 day. Creatures slain by death effects cannot be saved by breath of life. Like cure spells, breath of life deals damage to undead creatures rather than curing them, and cannot bring them back to life."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow(
                "Will negates (harmless) or Will half, see text"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bull's Strength")->setLongDescription(
            "The subject becomes stronger. The spell grants a +4 enhancement bonus to Strength, adding the usual benefits to melee attack rolls, melee damage rolls, and other uses of the Strength modifier."
        )->setCastingTime("1 standard action")->setComponents("a few hairs, or a pinch of dung, from a bull")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Bull's Strength, Mass")->setLongDescription(
            "This spell functions like <a href=\"Bull's Strength\">bull's strength</a>, except that it affects multiple creatures."
        )->setCastingTime("1 standard action")->setComponents("a few hairs, or a pinch of dung, from a bull")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Burning Hands")->setLongDescription(
            "A cone of searing flame shoots from your fingertips. Any creature in the area of the flames takes 1d4 points of fire damage per caster level (maximum 5d4). Flammable materials burn if the flames touch them. A character can extinguish burning items as a full-round action."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("15 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Call Lightning")->setLongDescription(
            "Immediately upon completion of the spell, and once per round thereafter, you may call down a 5-foot-wide, 30-foot-long, vertical bolt of lightning that deals 3d6 points of electricity damage. The bolt of lightning flashes down in a vertical stroke at whatever target point you choose within the spell's range (measured from your position at the time). Any creature in the target square or in the path of the bolt is affected. You need not call a bolt of lightning immediately; other actions, even spellcasting, can be performed first. Each round after the first you may use a standard action (concentrating on the spell) to call a bolt. You may call a total number of bolts equal to your caster level (maximum 10 bolts). If you are outdoors and in a stormy area--a rain shower, clouds and wind, hot and cloudy conditions, or even a tornado (including a whirlwind formed by a djinni or an air elemental of at least Large size)--each bolt deals 3d10 points of electricity damage instead of 3d6. This spell functions indoors or underground but not underwater."
        )->setCastingTime("1 round")->setComponents("")->setRange("medium (100 ft. + 10 ft./level)")->setTargets(
                ""
            )->setDuration("1 min./level")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Call Lightning Storm")->setLongDescription(
            "This spell functions like <a href=\"Call Lightning\">call lightning</a>, except that each bolt deals 5d6 points of electricity damage (or 5d10 if created outdoors in a stormy area), and you may call a maximum of 15 bolts."
        )->setCastingTime("1 round")->setComponents("")->setRange("long (400 ft. + 40 ft./level)")->setTargets(
                ""
            )->setDuration("1 min./level")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Calm Animals")->setLongDescription(
            "This spell soothes and quiets animals, rendering them docile and harmless. Only ordinary animals (those with Intelligence scores of 1 or 2) can be affected by this spell. All the subjects must be of the same kind, and no two may be more than 30 feet apart. The maximum number of HD of animals you can affect is equal to 2d4 + caster level.  The affected creatures remain where they are and do not attack or flee. They are not helpless and defend themselves normally if attacked. Any threat breaks the spell on the threatened creatures."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("animals within 30 ft. of each other")->setDuration("1 min./level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Calm Emotions")->setLongDescription(
            "This spell calms agitated creatures. You have no control over the affected creatures, but calm emotions can stop raging creatures from fighting or joyous ones from reveling. Creatures so affected cannot take violent actions (although they can defend themselves) or do anything destructive. Any aggressive action against or damage dealt to a calmed creature immediately breaks the spell on all calmed creatures. This spell automatically suppresses (but does not dispel) any morale bonuses granted by spells such as <a href=\"Bless\">bless</a>, <a href=\"Good Hope\">good hope</a>, and <a href=\"Rage\">rage</a>, and also negates a bard's ability to inspire courage or a barbarian's rage ability. It also suppresses any fear effects and removes the confused condition from all targets. While the spell lasts, a suppressed spell, condition, or effect has no effect. When the calm emotions spell ends, the original spell or effect takes hold of the creature again, provided that its duration has not expired in the meantime."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("concentration, up to 1 round/level (D)")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cat's Grace")->setLongDescription(
            "The transmuted creature becomes more graceful, agile, and coordinated. The spell grants a +4 enhancement bonus to Dexterity, adding the usual benefits to AC, Reflex saves, and other uses of the Dexterity modifier."
        )->setCastingTime("1 standard action")->setComponents("pinch of cat fur")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cat's Grace, Mass")->setLongDescription(
            "This spell functions like <a href=\"Cat's Grace\">cat's grace</a>, except that it affects multiple creatures."
        )->setCastingTime("1 standard action")->setComponents("pinch of cat fur")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cause Fear")->setLongDescription(
            "The affected creature becomes frightened. If the subject succeeds on a Will save, it is shaken for 1 round. Creatures with 6 or more HD are immune to this effect. Cause fear counters and dispels <a href=\"Remove Fear\">remove fear</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature with 5 or fewer HD")->setDuration(
                "1d4 rounds or 1 round; see text"
            )->setSavingThrow("Will partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Chain Lightning")->setLongDescription(
            "This spell creates an electrical discharge that begins as a single stroke commencing from your fingertips. Unlike <a href=\"Lightning Bolt\">lightning bolt</a>, chain lightning strikes one object or creature initially, then arcs to other targets. The bolt deals 1d6 points of electricity damage per caster level (maximum 20d6) to the primary target. After it strikes, lightning can arc to a number of secondary targets equal to your caster level (maximum 20). The secondary bolts each strike one target and deal as much damage as the primary bolt. Each target can attempt a Reflex saving throw for half damage. The Reflex DC to halve the damage of the secondary bolts is 2 lower than the DC to halve the damage of the primary bolt. You choose secondary targets as you like, but they must all be within 30 feet of the primary target, and no target can be struck more than once. You can choose to affect fewer secondary targets than the maximum."
        )->setCastingTime("1 standard action")->setComponents(
                "a bit of fur; a piece of amber, glass, or a crystal rod; plus one silver pin per caster level"
            )->setRange("long (400 ft. + 40 ft./level)")->setTargets(
                "one primary target, plus one secondary target/level (each of which must be within 30 ft. of the primary target)"
            )->setDuration("instantaneous")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Changestaff")->setLongDescription(
            "You change a specially prepared quarterstaff into a Huge treant-like creature, about 24 feet tall. When you plant the end of the staff in the ground and speak a special command to conclude the casting of the spell, your staff turns into a creature that looks and fights just like a treant. The staff-treant defends you and obeys any spoken commands. However, it is by no means a true treant; it cannot converse with actual treants or control trees. If the staff-treant is reduced to 0 or fewer hit points, it crumbles to powder and the staff is destroyed. Otherwise, the staff returns to its normal form when the spell duration expires (or when the spell is dismissed), and it can be used as the focus for another casting of the spell. The staff-treant is always at full strength when created, despite any wounds it may have incurred the last time it appeared."
        )->setCastingTime("1 round")->setComponents(
                "a quarterstaff that has been carved and polished for 28 days"
            )->setRange("touch")->setTargets("your touched staff")->setDuration("1 hour/level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Chaos Hammer")->setLongDescription(
            "You unleash chaotic power to smite your enemies. The power takes the form of a multicolored explosion of leaping, ricocheting energy. Only lawful and neutral (not chaotic) creatures are harmed by the spell. The spell deals 1d8 points of damage per two caster levels (maximum 5d8) to lawful creatures (or 1d6 points of damage per caster level, maximum 10d6, to lawful outsiders) and slows them for 1d6 rounds (see the slow spell). A successful Will save reduces the damage by half and negates the slow effect. The spell deals only half damage against creatures who are neither lawful nor chaotic, and they are not slowed. Such a creature can reduce the damage by half again (down to one-quarter) with a successful Will save."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous (1d6 rounds); see text")->setSavingThrow(
                "Will partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Charm Animal")->setLongDescription(
            "This spell functions like <a href=\"Charm Person\">charm person</a>, except that it affects a creature of the animal type."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one animal")->setDuration("1 hour/level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Charm Monster")->setLongDescription(
            "This spell functions like <a href=\"Charm Person\">charm person</a>, except that the effect is not restricted by creature type or size."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("1 day/level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Charm Monster, Mass")->setLongDescription(
            "This spell functions like <a href=\"Charm Monster\">charm monster</a>, except that mass charm monster affects a number of creatures whose combined HD do not exceed twice your level, or at least one creature regardless of HD. If there are more potential targets than you can affect, you choose them one at a time until you must choose a creature with too many HD to affect."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("One or more creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "1 day/level"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Charm Person")->setLongDescription(
            "This charm makes a humanoid creature regard you as its trusted friend and ally (treat the target's attitude as friendly). If the creature is currently being threatened or attacked by you or your allies, however, it receives a +5 bonus on its saving throw. The spell does not enable you to control the charmed person as if it were an automaton, but it perceives your words and actions in the most favorable way. You can try to give the subject orders, but you must win an opposed Charisma check to convince it to do anything it wouldn't ordinarily do. (Retries are not allowed.) An affected creature never obeys suicidal or obviously harmful orders, but it might be convinced that something very dangerous is worth doing. Any act by you or your apparent allies that threatens the charmed person breaks the spell. You must speak the person's language to communicate your commands, or else be good at pantomiming."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one humanoid creature")->setDuration("1 hour/level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Chill Metal")->setLongDescription(
            "Chill metal makes metal extremely cold. Unattended, nonmagical metal gets no saving throw. Magical metal is allowed a saving throw against the spell. An item in a creature's possession uses the creature's saving throw bonus unless its own is higher. A creature takes cold damage if its equipment is chilled. It takes full damage if its armor, shield, or weapon is affected. The creature takes minimum damage (1 point or 2 points; see the table) if it's not wearing or wielding such an item. On the first round of the spell, the metal becomes chilly and uncomfortable to touch but deals no damage. The same effect also occurs on the last round of the spell's duration. During the second (and also the next-to-last) round, icy coldness causes pain and damage. In the third, fourth, and fifth rounds, the metal is freezing cold, and causes more damage, as shown on the table below. <table><tr><th>Round</th><th>Metal Temperature</th><th>Damage</th></tr><tr><td>1</td><td>Cold</td><td>None	</td></tr><tr class=\"alt\"><td>2</td><td>Icy</td><td>1d4 points</td></tr><tr><td>3-5</td><td>Freezing</td><td>2d4 points</td></tr><tr class=\"alt\"><td>6</td><td>Icy</td><td>1d4 points</td></tr><tr><td>7</td><td>Cold</td><td>None</td></tr></table> Any heat intense enough to damage the creature negates cold damage from the spell (and vice versa) on a point-for-point basis. Underwater, chill metal deals no damage, but ice immediately forms around the affected metal, making it float if unattended. Chill metal counters and dispels <a href=\"Heat Metal\">heat metal</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "metal equipment of one creature per two levels, no two of which can be more than 30 ft. apart; or 25 lbs. of metal/level, none of which can be more than 30 ft. away from any of the rest"
            )->setDuration("7 rounds")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Chill Touch")->setLongDescription(
            "A touch from your hand, which glows with blue energy, disrupts the life force of living creatures. Each touch channels negative energy that deals 1d6 points of damage. The touched creature also takes 1 point of Strength damage unless it makes a successful Fortitude saving throw. You can use this melee touch attack up to one time per level. An undead creature you touch takes no damage of either sort, but it must make a successful Will saving throw or flee as if panicked for 1d4 rounds + 1 round per caster level."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature or creatures touched (up to one/level)"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude partial or Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Circle of Death")->setLongDescription(
            "Circle of death snuffs out the life force of living creatures, killing them instantly. The spell slays 1d4 HD worth of living creatures per caster level (maximum 20d4). Creatures with the fewest HD are affected first; among creatures with equal HD, those who are closest to the burst's point of origin are affected first. No creature of 9 or more HD can be affected, and HD that are not sufficient to affect a creature are wasted."
        )->setCastingTime("1 standard action")->setComponents("a crushed black pearl worth 500 gp")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Clairaudience/Clairvoyance")->setLongDescription(
            "Clairaudience/clairvoyance creates an invisible magical sensor at a specific location that enables you to hear or see (your choice) almost as if you were there. You don't need line of sight or line of effect, but the locale must be known--a place familiar to you, or an obvious one. Once you have selected the locale, the sensor doesn't move, but you can rotate it in all directions to view the area as desired. Unlike other <a href=\"Scrying\">scrying</a> spells, this spell does not allow magically or supernaturally enhanced senses to work through it. If the chosen locale is magically dark, you see nothing. If it is naturally pitch black, you can see in a 10-foot radius around the center of the spell's effect. Clairaudience/clairvoyance functions only on the plane of existence you are currently occupying."
        )->setCastingTime("10 minutes")->setComponents("a small horn or a glass eye")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Clenched Fist")->setLongDescription(
            "This spell functions like <a href=\"Interposing Hand\">interposing hand</a>, except that the hand can also push or strike one opponent that you select. The floating hand can move as far as 60 feet and can attack in the same round. Since this hand is directed by you, its ability to notice or attack invisible or concealed creatures is no better than yours. The hand attacks once per round, and its attack bonus equals your caster level + your Intelligence, Wisdom, or Charisma modifier (for a wizard, cleric, or sorcerer, respectively) + 11 for the hand's Strength score (33), - 1 for being Large. The hand deals 1d8+11 points of damage on each attack, and any creature struck must make a Fortitude save (against this spell's save DC) or be stunned for 1 round. Directing the spell to a new target is a move action. The clenched fist can also interpose itself as <a href=\"Interposing Hand\">interposing hand</a> does, or it can bull rush an opponent as <a href=\"Forceful Hand\">forceful hand</a> does. Its CMB for bull rush checks uses your caster level in place of its base attack bonus, with a +11 bonus for its Strength score and a +1 bonus for being Large."
        )->setCastingTime("")->setComponents("a leather glove")->setRange("")->setTargets("")->setDuration(
                ""
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cloak of Chaos")->setLongDescription(
            "A random pattern of color surrounds the subjects, protecting them from attacks, granting them resistance to spells cast by lawful creatures, and causing lawful creatures that strike the subjects to become confused. This abjuration has four effects. First, each warded creature gains a +4 deflection bonus to AC and a +4 resistance bonus on saves. Unlike <a href=\"Protection from Law\">protection from law</a>, the benefit of this spell applies against all attacks, not just against attacks by lawful creatures. Second, each warded creature gains spell resistance 25 against lawful spells and spells cast by lawful creatures. Third, the abjuration protects from possession and mental influence, just as <a href=\"Protection from Law\">protection from law</a> does. Finally, if a lawful creature succeeds on a melee attack against a warded creature, the offending attacker is confused for 1 round (Will save negates, as with the <a href=\"Confusion\">confusion</a> spell, but against the save DC of cloak of chaos)."
        )->setCastingTime("1 standard action")->setComponents("a tiny reliquary worth 500 gp")->setRange(
                "20 ft."
            )->setTargets("one creature/level in a 20-ft.-radius burst centered on you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Clone")->setLongDescription(
            "This spell makes an inert duplicate of a creature. If the original individual has been slain, its soul immediately transfers to the clone, creating a replacement (provided that the soul is free and willing to return). The original's physical remains, should they still exist, become inert and cannot thereafter be restored to life. If the original creature has reached the end of its natural life span (that is, it has died of natural causes), any cloning attempt fails. To create the duplicate, you must have a piece of flesh (not hair, nails, scales, or the like) with a volume of at least 1 cubic inch that was taken from the original creature's living body. The piece of flesh need not be fresh, but it must be kept from rotting. Once the spell is cast, the duplicate must be grown in a laboratory for 2d4 months. When the clone is completed, the original's soul enters it immediately, if that creature is already dead. The clone is physically identical to the original and possesses the same personality and memories as the original. In other respects, treat the clone as if it were the original character raised from the dead, including its gaining of two permanent negative levels, just as if it had been hit by an energy-draining creature. If the subject is 1st level, it takes 2 points of Constitution drain instead (if this would reduce its Con to 0 or less, it can't be cloned). If the original creature gained permanent negative levels since the flesh sample was taken, the clone gains these negative levels as well. The spell duplicates only the original's body and mind, not its equipment. A duplicate can be grown while the original still lives, or when the original soul is unavailable, but the resulting body is merely a soulless bit of inert flesh which rots if not preserved."
        )->setCastingTime("10 minutes")->setComponents(
                "laboratory supplies worth 1,000 gp & special laboratory equipment costing 500 gp"
            )->setRange("0 ft.")->setTargets("")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cloudkill")->setLongDescription(
            "This spell generates a bank of fog, similar to a <a href=\"Fog Cloud\">fog cloud</a>, except that its vapors are yellowish green and poisonous. These vapors automatically kill any living creature with 3 or fewer HD (no save). A living creature with 4 to 6 HD is slain unless it succeeds on a Fortitude save (in which case it takes 1d4 points of Constitution damage on your turn each round while in the cloud). A living creature with 6 or more HD takes 1d4 points of Constitution damage on your turn each round while in the cloud (a successful Fortitude save halves this damage). Holding one's breath doesn't help, but creatures immune to poison are unaffected by the spell. Unlike a <a href=\"Fog Cloud\">fog cloud</a>, the cloudkill moves away from you at 10 feet per round, rolling along the surface of the ground. Figure out the cloud's new spread each round based on its new point of origin, which is 10 feet farther away from the point of origin where you cast the spell. Because the vapors are heavier than air, they sink to the lowest level of the land, even pouring down den or sinkhole openings. It cannot penetrate liquids, nor can it be cast underwater."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Fortitude partial")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Color Spray")->setLongDescription(
            "A vivid cone of clashing colors springs forth from your hand, causing creatures to become stunned, perhaps also blinded, and possibly knocking them unconscious. Each creature within the cone is affected according to its HD. 2 HD or less: The creature is unconscious, blinded, and stunned for 2d4 rounds, then blinded and stunned for 1d4 rounds, and then stunned for 1 round. (Only living creatures are knocked unconscious.) 3 or 4 HD: The creature is blinded and stunned for 1d4 rounds, then stunned for 1 round. 5 or more HD: The creature is stunned for 1 round. Sightless creatures are not affected by color spray."
        )->setCastingTime("1 standard action")->setComponents("red, yellow, and blue powder or colored sand")->setRange(
                "15 ft."
            )->setTargets("")->setDuration("instantaneous; see text")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Command")->setLongDescription(
            "You give the subject a single command, which it obeys to the best of its ability at its earliest opportunity. You may select from the following options. Approach: On its turn, the subject moves toward you as quickly and directly as possible for 1 round. The creature may do nothing but move during its turn, and it provokes attacks of opportunity for this movement as normal. Drop: On its turn, the subject drops whatever it is holding. It can't pick up any dropped item until its next turn. Fall: On its turn, the subject falls to the ground and remains prone for 1 round. It may act normally while prone but takes any appropriate penalties. Flee: On its turn, the subject moves away from you as quickly as possible for 1 round. It may do nothing but move during its turn, and it provokes attacks of opportunity for this movement as normal. Halt: The subject stands in place for 1 round. It may not take any actions but is not considered helpless. If the subject can't carry out your command on its next turn, the spell automatically fails."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("1 round")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Command, Greater")->setLongDescription(
            "This spell functions like command, except that up to one creature per level may be affected, and the activities continue beyond 1 round. At the start of each commanded creature's action after the first, it gets another Will save to attempt to break free from the spell. Each creature must receive the same command."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 round/level"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Command Plants")->setLongDescription(
            "This spell allows you some degree of control over one or more plant creatures. Affected plant creatures can understand you, and they perceive your words and actions in the most favorable way (treat their attitude as friendly). They will not attack you while the spell lasts. You can try to give a subject orders, but you must win an opposed Charisma check to convince it to do anything it wouldn't ordinarily do. (Retries are not allowed.) A commanded plant never obeys suicidal or obviously harmful orders, but it might be convinced that something very dangerous is worth doing. You can affect a number of plant creatures whose combined level or HD do not exceed twice your level."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "up to 2 HD/level of plant creatures, no two of which can be more than 30 ft. apart"
            )->setDuration("1 day/level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Command Undead")->setLongDescription(
            "This spell allows you a degree of control over an undead creature. If the subject is intelligent, it perceives your words and actions favorably (treat its attitude as friendly). It will not attack you while the spell lasts. You can give the subject orders, but you must win an opposed Charisma check to convince it to do anything it wouldn't ordinarily do. Retries are not allowed. An intelligent commanded undead never obeys suicidal or obviously harmful orders, but it might be convinced that something very dangerous is worth doing. A nonintelligent undead creature gets no saving throw against this spell. When you control a mindless being, you can communicate only basic commands, such as come here, go there, fight, stand still, and so on. Nonintelligent undead won't resist suicidal or obviously harmful orders. Any act by you or your apparent allies that threatens the commanded undead (regardless of its Intelligence) breaks the spell. Your commands are not telepathic. The undead creature must be able to hear you."
        )->setCastingTime("1 standard action")->setComponents("a shred of raw meat and a splinter of bone")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one undead creature")->setDuration("1 day/level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Commune")->setLongDescription(
            "You contact your deity--or agents thereof--and ask questions that can be answered by a simple yes or no. (A cleric of no particular deity contacts a philosophically allied deity.) You are allowed one such question per caster level. The answers given are correct within the limits of the entity's knowledge. Unclear is a legitimate answer, because powerful beings of the Outer Planes are not necessarily omniscient. In cases where a one-word answer would be misleading or contrary to the deity's interests, a short phrase (five words or less) may be given as an answer instead. The spell, at best, provides information to aid character decisions. The entities contacted structure their answers to further their own purposes. If you lag, discuss the answers, or go off to do anything else, the spell ends."
        )->setCastingTime("10 minutes")->setComponents("holy or unholy water and incense worth 500 gp")->setRange(
                "personal"
            )->setTargets("you")->setDuration("1 round/level")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Commune with Nature")->setLongDescription(
            "You become one with nature, attaining knowledge of the surrounding territory. You instantly gain knowledge of as many as three facts from among the following subjects: the ground or terrain, plants, minerals, bodies of water, people, general animal population, presence of woodland creatures, presence of powerful unnatural creatures, or even the general state of the natural setting. In outdoor settings, the spell operates in a radius of 1 mile per caster level. In natural underground settings--caves, caverns, and the like--the spell is less powerful, and its radius is limited to 100 feet per caster level. The spell does not function where nature has been replaced by construction or settlement, such as in dungeons and towns."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "instantaneous"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Comprehend Languages")->setLongDescription(
            "You can understand the spoken words of creatures or read otherwise incomprehensible written messages. The ability to read does not necessarily impart insight into the material, merely its literal meaning. The spell enables you to understand or read an unknown language, not speak or write it. Written material can be read at the rate of one page (250 words) per minute. Magical writing cannot be read, though the spell reveals that it is magical. This spell can be foiled by certain warding magic (such as the <a href=\"Secret Page\">secret page</a> and <a href=\"Illusory Script\">illusory script</a> spells). It does not decipher codes or reveal messages concealed in otherwise normal text. Comprehend languages can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("pinch of soot and salt")->setRange(
                "personal"
            )->setTargets("you")->setDuration("10 min./level")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cone of Cold")->setLongDescription(
            "Cone of cold creates an area of extreme cold, originating at your hand and extending outward in a cone. It drains heat, dealing 1d6 points of cold damage per caster level (maximum 15d6)."
        )->setCastingTime("1 standard action")->setComponents("a small crystal or glass cone")->setRange(
                "60 ft."
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Confusion")->setLongDescription(
            "This spell causes confusion in the targets, making them unable to determine their actions. Roll on the following table at the start of each subject's turn each round to see what it does in that round. <table><tr><th>d100</th><th>Behavior</th></tr><tr><td>01-25</td><td>Act normally</td></tr><tr class=\"alt\"><td>26-50</td><td>Do nothing but babble incoherently</td></tr><tr><td>51-75</td><td>Deal 1d8 points of damage + Str modifier to self with item in hand</td></tr><tr class=\"alt\"><td>76-100</td><td>Attack nearest creature (for this purpose, a familiar counts as part of the subject's self)</td></tr></table> A confused character who can't carry out the indicated action does nothing but babble incoherently. Attackers are not at any special advantage when attacking a confused character. Any confused character who is attacked automatically attacks its attackers on its next turn, as long as it is still confused when its turn comes. Note that a confused character will not make attacks of opportunity against any creature that it is not already devoted to attacking (either because of its most recent action or because it has just been attacked)."
        )->setCastingTime("1 standard action")->setComponents("three nutshells")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("all creatures in a 15-ft.-radius burst")->setDuration("1 round/level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Confusion, Lesser")->setLongDescription(
            "This spell causes a single creature to become confused for 1 round. "
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("1 round")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Consecrate")->setLongDescription(
            "This spell blesses an area with positive energy. The DC to resist positive channeled energy within this area gains a +3 sacred bonus. Every undead creature entering a consecrated area suffers minor disruption, suffering a -1 penalty on attack rolls, damage rolls, and saves. Undead cannot be created within or summoned into a consecrated area. If the consecrated area contains an altar, shrine, or other permanent fixture dedicated to your deity, pantheon, or aligned higher power, the modifiers given above are doubled (+6 sacred bonus to positive channeled energy DCs, -2 penalties for undead in the area). You cannot consecrate an area with a similar fixture of a deity other than your own patron. Instead, the consecrate spell curses the area, cutting off its connection with the associated deity or power. This secondary function, if used, does not also grant the bonuses and penalties relating to undead, as given above. Consecrate counters and dispels <a href=\"Desecrate\">desecrate</a>."
        )->setCastingTime("1 standard action")->setComponents(
                "a vial of holy water and 25 gp worth of silver dust"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration(
                "2 hours/level"
            )->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Contact Other Plane")->setLongDescription(
            "You send your mind to another plane of existence (an Elemental Plane or some plane farther removed) in order to receive advice and information from powers there. See the accompanying table for possible consequences and results of the attempt. The powers reply in a language you understand, but they resent such contact and give only brief answers to your questions. All questions are answered with yes,no,maybe,never,irrelevant,or some other one-word answer. You must concentrate on maintaining the spell (a standard action) in order to ask questions at the rate of one per round. A question is answered by the power during the same round. You may ask one question for every two caster levels. Contact with minds far removed from your home plane increases the probability that you will incur a decrease in Intelligence and Charisma due to your brain being overwhelmed, but also increases the chance of the power knowing the answer and answering correctly. Once the Outer Planes are reached, the power of the deity contacted determines the effects. (Random results obtained from the table are subject to the personalities of individual deities.) On rare occasions, this divination may be blocked by an act of certain deities or forces. Avoid Int/Cha Decrease: You must succeed on an Intelligence check against this DC to avoid a decrease in Intelligence and Charisma. If the check fails, your Intelligence and Charisma scores each fall to 8 for the stated duration, and you become unable to cast arcane spells. If you lose Intelligence and Charisma, the effect strikes as soon as the first question is asked, and no answer is received. If a successful contact is made, roll d% to determine the type of answer you gain. True Answer: You get a true, one-word answer. Questions that cannot be answered in this way are answered randomly. Don't Know: The entity tells you that it doesn't know. Lie: The entity intentionally lies to you. Random Answer: The entity tries to lie but doesn't know the answer, so it makes one up. <table><tr><th>Plane Contacted</th><th>Avoid Int/Cha Decrease</th><th>True Answer</th><th>Don't Know</th><th>Lie</th><th>Random Answer</th></tr>	<tr><td>Elemental Plane</td><td>DC 7/1 week</td><td>01-34</td><td>35-62</td><td>63-83</td><td>84-100</td></tr><tr class=\"alt\"><td>Positive/Negative Energy Plane</td><td>DC 8/1 week</td><td>01-39</td><td>40-65</td><td>66-86</td><td>87-100</td></tr><tr><td>Astral Plane</td><td>DC 9/1 week</td><td>01-44</td><td>45-67</td><td>68-88</td><td>89-100</td></tr><tr class=\"alt\"><td>Outer Plane, demigod</td><td>DC 10/2 weeks</td><td>01-49</td><td>50-70</td><td>71-91</td><td>92-100</td></tr><tr><td>Outer Plane, lesser deity</td><td>DC 12/3 weeks</td><td>01-60</td><td>61-75</td><td>76-95</td><td>96-100	</td></tr><tr class=\"alt\"><td>Outer Plane, intermediate deity</td><td>DC 14/4 weeks</td><td>01-73</td><td>74-81</td><td>82-98</td><td>99-100</td></tr><tr><td>Outer Plane, greater deity</td><td>DC 16/5 weeks</td><td>01-88</td><td>89-90</td><td>91-99</td><td>100</td></tr></table>"
        )->setCastingTime("10 minutes")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "concentration"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Contagion")->setLongDescription(
            "The subject contracts one of the following diseases: blinding sickness, bubonic plague, cackle fever, filth fever, leprosy, mindfire, red ache, shakes, or slimy doom. The disease is contracted immediately (the onset period does not apply). Use the disease's listed frequency and save DC to determine further effects. For more information see Diseases. "
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Contingency")->setLongDescription(
            "You can place another spell upon your person so that it comes into effect under some condition you dictate when casting contingency. The contingency spell and the companion spell are cast at the same time. The 10-minute casting time is the minimum total for both castings; if the companion spell has a casting time longer than 10 minutes, use that instead. You must pay any costs associated with the companion spell when you cast contingency. The spell to be brought into effect by the contingency must be one that affects your person and be of a spell level no higher than one-third your caster level (rounded down, maximum 6th level). The conditions needed to bring the spell into effect must be clear, although they can be general. In all cases, the contingency immediately brings into effect the companion spell, the latter being cast instantaneously when the prescribed circumstances occur. If complicated or convoluted conditions are prescribed, the whole spell combination (contingency and the companion magic) may fail when triggered. The companion spell occurs based solely on the stated conditions, regardless of whether you want it to. You can use only one contingency spell at a time; if a second is cast, the first one (if still active) is dispelled."
        )->setCastingTime("at least 10 minutes; see text")->setComponents(
                "quicksilver and an eyelash of a spell-using creature & ivory statuette of you worth 1,500 gp"
            )->setRange("personal")->setTargets("you")->setDuration(
                "1 day/level (D) or until discharged"
            )->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Continual Flame")->setLongDescription(
            "A flame, equivalent in brightness to a torch, springs forth from an object that you touch. The effect looks like a regular flame, but it creates no heat and doesn't use oxygen. A continual flame can be covered and hidden but not smothered or quenched. Light spells counter and dispel darkness spells of an equal or lower level."
        )->setCastingTime("1 standard action")->setComponents("ruby dust worth 50 gp")->setRange("touch")->setTargets(
                "object touched"
            )->setDuration("permanent")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Control Plants")->setLongDescription(
            "This spell enables you to control the actions of one or more plant creatures for a short period of time. You command the creatures by voice and they understand you, no matter what language you speak. Even if vocal communication is impossible, the controlled plants do not attack you. At the end of the spell, the subjects revert to their normal behavior. Suicidal or self-destructive commands are simply ignored."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "up to 2 HD/level of plant creatures, no two of which can be more than 30 ft. apart"
            )->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Control Undead")->setLongDescription(
            "This spell enables you to control undead creatures for a short period of time. You command them by voice and they understand you, no matter what language you speak. Even if vocal communication is impossible, the controlled undead do not attack you. At the end of the spell, the subjects revert to their normal behavior. Intelligent undead creatures remember that you controlled them, and they may seek revenge after the spell's effects end."
        )->setCastingTime("1 standard action")->setComponents("a piece of bone and a piece of raw meat")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "up to 2 HD/level of undead creatures, no two of which can be more than 30 ft. apart"
            )->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Control Water")->setLongDescription(
            "This spell has two different applications, both of which control water in different ways. The first version of this spell causes water in the area to swiftly evaporate or to sink into the ground below, lowering the water's depth. The second version causes the water to surge and rise, increasing its overall depth and possibly flooding nearby areas. Lower Water: This causes water or similar liquid to reduce its depth by as much as 2 feet per caster level (to a minimum depth of 1 inch). The water is lowered within a squarish depression whose sides are up to caster level x 10 feet long. In extremely large and deep bodies of water, such as a deep ocean, the spell creates a whirlpool that sweeps ships and similar craft downward, putting them at risk and rendering them unable to leave by normal movement for the duration of the spell. When cast on water elementals and other water-based creatures, this spell acts as a slow spell (Will negates). The spell has no effect on other creatures. Raise Water: This causes water or similar liquid to rise in height, just as the lower water version causes it to lower. Boats raised in this way slide down the sides of the hump that the spell creates. If the area affected by the spell includes riverbanks, a beach, or other land nearby, the water can spill over onto dry land. With either version of this spell, you may reduce one horizontal dimension by half and double the other horizontal dimension to change the overall area of effect."
        )->setCastingTime("1 standard action")->setComponents(
                "a pinch of dust for lower water or a drop of water for raise water"
            )->setRange("long (400 ft. + 40 ft./level)")->setTargets("")->setDuration(
                "10 min./level (D)"
            )->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Control Weather")->setLongDescription(
            "You change the weather in the local area. It takes 10 minutes to cast the spell and an additional 10 minutes for the effects to manifest. You can call forth weather appropriate to the climate and season of the area you are in. You can also use this spell to cause the weather in the area to become calm and normal for the season. <table><tr><th>Season</th><th>Possible Weather</th></tr><tr><td>Spring</td><td>Tornado, thunderstorm, sleet storm,  or hot weather</td></tr><tr><td class=\"alt\">Summer</td><td>Torrential rain, heat wave, or hailstorm</td></tr><tr><td>Autumn</td><td>Hot or cold weather, fog, or sleet</td></tr><tr><td class=\"alt\">Winter</td><td>Frigid cold, blizzard, or thaw</td></tr><tr><td>Late winter</td><td>Hurricane-force winds or early spring</td></tr></table> You control the general tendencies of the weather, such as the direction and intensity of the wind. You cannot control specific applications of the weather--where lightning strikes, for example, or the exact path of a tornado. The weather continues as you left it for the duration, or until you use a standard action to designate a new kind of weather (which fully manifests itself 10 minutes later). Contradictory conditions are not possible simultaneously. Control weather can do away with atmospheric phenomena (naturally occurring or otherwise) as well as create them. A druid casting this spell doubles the duration and affects a circle with a 3-mile radius."
        )->setCastingTime("10 minutes; see text")->setComponents("")->setRange("2 miles")->setTargets("")->setDuration(
                "4d12 hours; see text"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Control Winds")->setLongDescription(
            "You alter wind force in the area surrounding you. You can make the wind blow in a certain direction or manner, increase its strength, or decrease its strength. The new wind direction and strength persist until the spell ends or until you choose to alter your handiwork, which requires concentration. You may create an eye of calm air up to 80 feet in diameter at the center of the area if you so desire, and you may choose to limit the area to any cylindrical area less than your full limit. Wind Direction: You may choose one of four basic wind patterns to function over the spell's area. * A downdraft blows from the center outward in equal strength in all directions.
* An updraft blows from the outer edges in toward the center in equal strength from all directions, veering upward before impinging on the eye in the center.
* Rotation causes the winds to circle the center in clockwise or counterclockwise fashion.
* A blast simply causes the winds to blow in one direction across the entire area from one side to the other.
Wind Strength: For every three caster levels, you can increase or decrease wind strength by one level. Each round on your turn, a creature in the wind must make a Fortitude save or suffer the effect of being in the windy area. See Environment for more details. Strong winds (21+ mph) make sailing difficult. A severe wind (31+ mph) causes minor ship and building damage. A windstorm (51+ mph) drives most flying creatures from the skies, uproots small trees, knocks down light wooden structures, tears off roofs, and endangers ships. Hurricane force winds (75+ mph) destroy wooden buildings, uproot large trees, and cause most ships to founder. A tornado (175+ mph) destroys all nonfortified buildings and often uproots large trees."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("40 ft./level")->setTargets(
                ""
            )->setDuration("10 min./level")->setSavingThrow("Fortitude negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Create Food and Water")->setLongDescription(
            "The food that this spell creates is simple fare of your choice--highly nourishing, if rather bland. Food so created decays and becomes inedible after 24 hours, although it can be kept fresh for another 24 hours by casting a purify food and water spell on it. The water created by this spell is just like clean rain water, and it doesn't go bad as the food does."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("24 hours; see text")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Create Greater Undead")->setLongDescription(
            "This spell functions like <a href=\"Create Undead\">create undead</a>, except that you can create more powerful and intelligent sorts of undead: shadows, wraiths, spectres, and devourers. The type or types of undead created is based on caster level, as shown below. <table><tr><th>Caster Level</th><th>Undead Created</th></tr><tr><td>15th or lower</td><td>Shadow</td></tr><tr class=\"alt\"><td>16th-17th</td><td>Wraith</td></tr><tr><td>18th-19th</td><td>Spectre</td></tr><tr class=\"alt\"><td>20th or higher</td><td>Devourer</td></tr></table>"
        )->setCastingTime("1 hour")->setComponents(
                "a clay pot filled with grave dirt and an onyx gem worth at least 50 gp per HD of the undead to be created"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("one corpse")->setDuration(
                "instantaneous"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Create Undead")->setLongDescription(
            "A much more potent spell than <a href=\"Animate Dead\">animate dead</a>, this evil spell allows you to infuse a dead body with negative energy to create more powerful sorts of undead: ghouls, ghasts, mummies, and mohrgs. The type or types of undead you can create are based on your caster level, as shown on the table below. <table><tr><th>Caster Level</th><th>Undead Created</td></tr><tr><td>11th or lower</td><td>Ghoul</td></tr><tr class=\"alt\"><td>12th-14th</td><td>Ghast</td></tr><tr><td>15th-17th</td><td>Mummy</td></tr><tr class=\"alt\"><td>18th or higher</td><td>Mohrg</td></tr></table> You may create less powerful undead than your level would allow if you choose. Created undead are not automatically under the control of their animator. If you are capable of commanding undead, you may attempt to command the undead creature as it forms. This spell must be cast at night."
        )->setCastingTime("1 hour")->setComponents(
                "a clay pot filled with grave dirt and an onyx gem worth at least 50 gp per HD of the undead to be created"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("one corpse")->setDuration(
                "instantaneous"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Create Water")->setLongDescription(
            "This spell generates wholesome, drinkable water, just like clean rain water. Water can be created in an area as small as will actually contain the liquid, or in an area three times as large--possibly creating a downpour or filling many small receptacles. This water disappears after 1 day if not consumed. Note: Conjuration spells can't create substances or objects within a creature. Water weighs about 8 pounds per gallon. One cubic foot of water contains roughly 8 gallons and weighs about 60 pounds."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Creeping Doom")->setLongDescription(
            "This spell summons four massive swarms of biting and stinging insects. These swarms appear adjacent to one another, but can be directed to move independently. Treat these swarms as centipede swarms with the following adjustments. The swarms have 60 hit points each and deal 4d6 points of damage with their swarm attack. The save to resist their poison and distraction effects is equal to the save DC of this spell. Creatures caught in multiple swarms only take damage and make saves once. You may summon the swarms so that they share the area of other creatures. As a standard action, you can command any number of the swarms to move toward any target within 100 feet of you. You cannot command any swarm to move more than 100 feet away from you, and if you move more than 100 feet from any swarm, that swarm remains stationary, attacking any creatures in its area (but can be commanded again if you move within 100 feet)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)/100 ft.; see text"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow(
                "Fortitude partial, see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Crushing Despair")->setLongDescription(
            "An invisible cone of despair causes great sadness in the subjects. Each affected creature takes a -2 penalty on attack rolls, saving throws, ability checks, skill checks, and weapon damage rolls. Crushing despair counters and dispels <a href=\"Good Hope\">good hope</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("30 ft.")->setTargets("")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Crushing Hand")->setLongDescription(
            "This spell functions as <a href=\"Interposing Hand\">interposing hand</a>, except that it can also grapple one opponent as <a href=\"Grasping Hand\">grasping hand</a>. Its CMB and CMD for grapple checks use your caster level in place of its base attack bonus, with a +12 bonus for its Strength score (35) and a +1 bonus for being Large (its Dexterity is 10, granting no bonus to the CMD). A crushing hand deals 2d6+12 points of damage on each successful grapple check against an opponent. The crushing hand can instead be directed to bull rush a target (as forceful hand), using the same bonuses outlined above, or it can be directed to interpose itself, as <a href=\"Interposing Hand\">interposing hand</a> does."
        )->setCastingTime("1 standard action")->setComponents("a soft glove")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Critical Wounds")->setLongDescription(
            "This spell functions like <a href=\"Cure Light Wounds\">cure light wounds</a>, except that it cures 4d8 points of damage + 1 point per caster level (maximum +20)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Critical Wounds, Mass")->setLongDescription(
            "This spell functions like mass cure light wounds, except that it cures 4d8 points of damage + 1 point per caster level (maximum +40)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half (harmless) or Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Light Wounds")->setLongDescription(
            "When laying your hand upon a living creature, you channel positive energy that cures 1d8 points of damage + 1 point per caster level (maximum +5). Since undead are powered by negative energy, this spell deals damage to them instead of curing their wounds. An undead creature can apply spell resistance, and can attempt a Will save to take half damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Light Wounds, Mass")->setLongDescription(
            "You channel positive energy to cure 1d8 points of damage + 1 point per caster level (maximum +25) on each selected creature. Like other cure spells, mass cure light wounds deals damage to undead in its area rather than curing them. Each affected undead may attempt a Will save for half damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half (harmless) or Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Moderate Wounds")->setLongDescription(
            "This spell functions like <a href=\"Cure Light Wounds\">cure light wounds</a>, except that it cures 2d8 points of damage + 1 point per caster level (maximum +10)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Moderate Wounds, Mass")->setLongDescription(
            "This spell functions like <a href=\"Cure Light Wounds, Mass\">mass cure light wounds</a>, except that it cures 2d8 points of damage + 1 point per caster level (maximum +30)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half (harmless) or Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Serious Wounds")->setLongDescription(
            "This spell functions like <a href=\"Cure Light Wounds\">cure light wounds</a>, except that it cures 3d8 points of damage + 1 point per caster level (maximum +15)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Cure Serious Wounds, Mass")->setLongDescription(
            "This spell functions like <a href=\"Cure Light Wounds, Mass\">mass cure light wounds</a>, except that it cures 3d8 points of damage + 1 point per caster level (maximum +35)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half (harmless) or Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Curse Water")->setLongDescription(
            "This spell imbues a flask (1 pint) of water with negative energy, turning it into unholy water (see Equipment). Unholy water damages good outsiders the way holy water damages undead and evil outsiders."
        )->setCastingTime("1 minute")->setComponents("5 lbs. of powdered silver worth 25 gp")->setRange(
                "touch"
            )->setTargets("flask of water touched")->setDuration("instantaneous")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dancing Lights")->setLongDescription(
            "Depending on the version selected, you create up to four lights that resemble lanterns or torches (and cast that amount of light), or up to four glowing spheres of light (which look like will-o'-wisps), or one faintly glowing, vaguely humanoid shape. The dancing lights must stay within a 10-foot-radius area in relation to each other but otherwise move as you desire (no concentration required): forward or back, up or down, straight or turning corners, or the like. The lights can move up to 100 feet per round. A light winks out if the distance between you and it exceeds the spell's range. You can only have one dancing lights spell active at any one time. If you cast this spell while another casting is still in effect, the previous casting is dispelled. If you make this spell permanent, it does not count against this limit. Dancing lights can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 minute (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Darkness")->setLongDescription(
            "This spell causes an object to radiate darkness out to a 20-foot radius. This darkness causes the illumination level in the area to drop one step, from bright light to normal light, from normal light to dim light, or from dim light to darkness. This spell has no effect in an area that is already dark. Creatures with light vulnerability or sensitivity take no penalties in normal light. All creatures gain concealment (20% miss chance) in dim light. All creatures gain total concealment (50% miss chance) in darkness. Creatures with darkvision can see in an area of dim light or darkness without penalty. Nonmagical sources of light, such as torches and lanterns, do not increase the light level in an area of darkness. Magical light sources only increase the light level in an area if they are of a higher spell level than darkness.  If darkness is cast on a small object that is then placed inside or under a lightproof covering, the spell's effect is blocked until the covering is removed. This spell does not stack with itself. Darkness can be used to counter or dispel any light spell of equal or lower spell level. "
        )->setCastingTime("1 standard action")->setComponents("bat fur and a piece of coal")->setRange(
                "touch"
            )->setTargets("object touched")->setDuration("1 min./level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Darkvision")->setLongDescription(
            "The subject gains the ability to see 60 feet even in total darkness. Darkvision is black and white only but otherwise like normal sight. Darkvision can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("either a pinch of dried carrot or an agate")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 hour/level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Daylight")->setLongDescription(
            "You touch an object when you cast this spell, causing the object to shed bright light in a 60-foot radius. This illumination increases the light level for an additional 60 feet by one step (darkness becomes dim light, dim light becomes normal light, and normal light becomes bright light). Creatures that take penalties in bright light take them while within the 60-foot radius of this magical light. Despite its name, this spell is not the equivalent of daylight for the purposes of creatures that are damaged or destroyed by such light. If daylight is cast on a small object that is then placed inside or under a light-proof covering, the spell's effects are blocked until the covering is removed. Daylight brought into an area of magical darkness (or vice versa) is temporarily negated, so that the otherwise prevailing light conditions exist in the overlapping areas of effect. Daylight counters or dispels any darkness spell of equal or lower level, such as darkness."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "object touched"
            )->setDuration("10 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Daze")->setLongDescription(
            "This spell clouds the mind of a humanoid creature with 4 or fewer Hit Dice so that it takes no actions. Humanoids of 5 or more HD are not affected. A dazed subject is not stunned, so attackers get no special advantage against it. After a creature has been dazed by this spell, it is immune to the effects of this spell for 1 minute."
        )->setCastingTime("1 standard action")->setComponents("a pinch of wool or similar substance")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one humanoid creature of 4 HD or less")->setDuration("1 round")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Daze Monster")->setLongDescription(
            "This spell functions like <a href=\"Daze\">daze</a>, but it can affect any one living creature of any type. Creatures of 7 or more HD are not affected."
        )->setCastingTime("1 standard action")->setComponents("a pinch of wool or similar substance")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one living creature of 6 HD or less")->setDuration("1 round")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Death Knell")->setLongDescription(
            "You draw forth the ebbing life force of a creature and use it to fuel your own power. Upon casting this spell, you touch a living creature that has -1 or fewer hit points. If the subject fails its saving throw, it dies, and you gain 1d8 temporary hit points and a +2 enhancement bonus to Strength. Additionally, your effective caster level goes up by +1, improving spell effects dependent on caster level. This increase in effective caster level does not grant you access to more spells. These effects last for 10 minutes per HD of the subject creature."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("instantaneous/10 minutes per HD of subject; see text")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Death Ward")->setLongDescription(
            "The subject gains a +4 morale bonus on saves against all death spells and magical death effects. The subject is granted a save to negate such effects even if one is not normally allowed. The subject is immune to <a href=\"Energy Drain\">energy drain</a> and any negative energy effects, including channeled negative energy. This spell does not remove negative levels that the subject has already gained, but it does remove the penalties from negative levels for the duration of its effect. Death ward does not protect against other sorts of attacks, even if those attacks might be lethal."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Deathwatch")->setLongDescription(
            "Using the powers of necromancy, you can determine the condition of creatures near death within the spell's range. You instantly know whether each creature within the area is dead, fragile (alive and wounded, with 3 or fewer hit points left), fighting off death (alive with 4 or more hit points), healthy, undead, or neither alive nor dead (such as a construct). Deathwatch sees through any spell or ability that allows creatures to feign death."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("30 ft.")->setTargets("")->setDuration(
                "10 min./level"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Deeper Darkness")->setLongDescription(
            "This spell functions as darkness, except that objects radiate darkness in a 60-foot radius and the light level is lowered by two steps. Bright light becomes dim light and normal light becomes darkness. Areas of dim light and darkness become supernaturally dark. This functions like darkness, but even creatures with darkvision cannot see within the spell's confines.  This spell does not stack with itself. Deeper darkness can be used to counter or dispel any light spell of equal or lower spell level."
        )->setCastingTime("1 standard action")->setComponents("bat fur and a piece of coal")->setRange(
                "touch"
            )->setTargets("object touched")->setDuration("10 min./level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Deep Slumber")->setLongDescription(
            "This spell functions like sleep, except that it affects 10 HD of targets."
        )->setCastingTime("1 round")->setComponents("fine sand, rose petals, or a live cricket")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Delayed Blast Fireball")->setLongDescription(
            "This spell functions like <a href=\"Fireball\">fireball</a>, except that it is more powerful and can detonate up to 5 rounds after the spell is cast. The burst of flame deals 1d6 points of fire damage per caster level (maximum 20d6). The glowing bead created by delayed blast fireball can detonate immediately if you desire, or you can choose to delay the burst for as many as 5 rounds. You select the amount of delay upon completing the spell, and that time cannot change once it has been set unless someone touches the bead. If you choose a delay, the glowing bead sits at its destination until it detonates. A creature can pick up and hurl the bead as a thrown weapon (range increment 10 feet). If a creature handles and moves the bead within 1 round of its detonation, there is a 25% chance that the bead detonates while being handled."
        )->setCastingTime("1 standard action")->setComponents("a ball of bat guano and sulfur")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("5 rounds or less; see text")->setSavingThrow(
                "Reflex half"
            )->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Delay Poison")->setLongDescription(
            "The subject becomes temporarily immune to poison. Any poison in its system or any poison to which it is exposed during the spell's duration does not affect the subject until the spell's duration has expired. Delay poison does not cure any damage that poison may have already done."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 hour/level")->setSavingThrow("Fortitude negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Demand")->setLongDescription(
            "This spell functions like <a href=\"Sending\">sending</a>, but the message can also contain a suggestion (see the <a href=\"Suggestion\">suggestion</a> spell), which the subject does its best to carry out. A successful Will save negates the suggestion effect but not the contact itself. The demand, if received, is understood even if the subject's Intelligence score is as low as 1. If the message is impossible or meaningless according to the circumstances that exist for the subject at the time the demand is issued, the message is understood but the suggestion is ineffective. The demand's message to the creature must be 25 words or less, including the suggestion. The creature can also give a short reply immediately."
        )->setCastingTime("10 minutes")->setComponents("fine copper wire")->setRange("see text")->setTargets(
                "one creature"
            )->setDuration("1 round; see text")->setSavingThrow("Will partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Desecrate")->setLongDescription(
            "This spell imbues an area with negative energy. The DC to resist negative channeled energy within this area gains a +3 profane bonus. Every undead creature entering a desecrated area gains a +1 profane bonus on all attack rolls, damage rolls, and saving throws. An undead creature created within or summoned into such an area gains +1 hit points per HD. If the desecrated area contains an altar, shrine, or other permanent fixture dedicated to your deity or aligned higher power, the modifiers given above are doubled (+6 profane bonus to negative channeled energy DCs, +2 profane bonus and +2 hit points per HD for undead created in the area). Furthermore, anyone who casts <a href=\"Animate Dead\">animate dead</a> within this area may create as many as double the normal amount of undead (that is, 4 HD per caster level rather than 2 HD per caster level). If the area contains an altar, shrine, or other permanent fixture of a deity, pantheon, or higher power other than your patron, the desecrate spell instead curses the area, cutting off its connection with the associated deity or power. This secondary function, if used, does not also grant the bonuses and penalties relating to undead, as given above. Desecrate counters and dispels <a href=\"Consecrate\">consecrate</a>."
        )->setCastingTime("1 standard action")->setComponents(
                "a vial of unholy water and 25 gp worth [5 pounds] of silver dust, all of which must be sprinkled around the area"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration(
                "2 hours/level"
            )->setSavingThrow(
                "none"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Destruction")->setLongDescription(
            "This spell instantly delivers 10 points of damage per caster level. If the spell slays the target, it consumes the remains utterly in holy (or unholy) fire (but not its equipment or possessions). If the target's Fortitude saving throw succeeds, it instead takes 10d6 points of damage. The only way to restore life to a character who has failed to save against this spell (and was slain) is to use true <a href=\"Resurrection\">resurrection</a>, a carefully worded <a href=\"Wish\">wish</a> spell followed by <a href=\"Resurrection\">resurrection</a>, or <a href=\"Miracle\">miracle</a>."
        )->setCastingTime("1 standard action")->setComponents("holy or unholy symbol costing 500 gp")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature")->setDuration("instantaneous")->setSavingThrow(
                "Fortitude partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Animals or Plants")->setLongDescription(
            "You can detect a particular kind of animal or plant in a cone emanating out from you in whatever direction you face. You must think of a kind of animal or plant when using the spell, but you can change the animal or plant kind each round. The amount of information revealed depends on how long you search a particular area or focus on a specific kind of animal or plant. 1st Round: Presence or absence of that kind of animal or plant in the area. 2nd Round: Number of individuals of the specified kind in the area and the condition of the healthiest specimen. 3rd Round: The condition (see below) and location of each individual present. If an animal or a plant is outside your line of sight, then you discern its direction but not its exact location. Conditions: For purposes of this spell, the categories of condition are as follows: Normal: Has at least 90% of full normal hit points, free of disease. Fair: 30% to 90% of full normal hit points remaining. Poor: Less than 30% of full normal hit points remaining, afflicted with a disease, or suffering from a debilitating injury. Weak: 0 or fewer hit points remaining, afflicted with a disease that has reduced an ability score to 5 or less, or crippled. If a creature falls into more than one category, the spell indicates the weaker of the two. Each round you can turn to detect a kind of animal or plant in a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("concentration, up to 10 min./level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Chaos")->setLongDescription(
            "This spell functions like <a href=\"Detect Evil\">detect evil</a>, except that it detects the auras of chaotic creatures, clerics of chaotic deities, chaotic spells, and chaotic magic items, and you are vulnerable to an overwhelming chaotic aura if you are lawful."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 10 min./ level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Evil")->setLongDescription(
            "You can sense the presence of evil. The amount of information revealed depends on how long you study a particular area or subject. 1st Round: Presence or absence of evil. 2nd Round: Number of evil auras (creatures, objects, or spells) in the area and the power of the most potent evil aura present. If you are of good alignment, and the strongest evil aura's power is overwhelming (see below), and the HD or level of the aura's source is at least twice your character level, you are stunned for 1 round and the spell ends. 3rd Round: The power and location of each aura. If an aura is outside your line of sight, then you discern its direction but not its exact location. Aura Power: An evil aura's power depends on the type of evil creature or object that you're detecting and its HD, caster level, or (in the case of a cleric) class level; see the table below. If an aura falls into more than one strength category, the spell indicates the stronger of the two. Lingering Aura: An evil aura lingers after its original source dissipates (in the case of a spell) or is destroyed (in the case of a creature or magic item). If detect evil is cast and directed at such a location, the spell indicates an aura strength of dim (even weaker than a faint aura). How long the aura lingers at this dim level depends on its original power: <table><tr><th>Original Strength</th><th>Duration of Lingering Aura</th></tr><tr><td>Faint</td><td>1d6 rounds</td></tr><tr class=\"alt\"><td>Moderate</td><td>1d6 minutes</td></tr><tr><td>Strong</td><td>1d6 x 10 minutes</td></tr><tr class=\"alt\"><td>Overwhelming</td><td>1d6 days</td></tr></table> Animals, traps, poisons, and other potential perils are not evil, and as such this spell does not detect them. Creatures with actively evil intents count as evil creatures for the purpose of this spell. Each round, you can turn to detect evil in a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it. <b>Detect Chaos/Evil/Good/Law</b><table><tr><th rowspan=\"2\">Creature/Object</th><th colspan=\"5\">Aura Power</th></tr><tr><th>None</th><th>Faint</th><th>Moderate</th><th>Strong</th><th>Overwhelming</th></tr><tr class=\"alt\"><td>Aligned creature 1 (HD)</td><td>5 or lower</td><td>5-10</td><td>11-25</td><td>26-50</td><td>51 or higher</td></tr><tr><td>Aligned Undead (HD)</td><td>--</td><td>2 or lower</td><td>3-8</td><td>9-20</td><td>21 or higher</td></tr><tr class=\"alt\"><td>Aligned outsider (HD)</td><td>--</td><td>1 or lower</td><td>2-4</td><td>5-10</td><td>11 or higher</td></tr><tr><td>Cleric or paladin of an aligned deity 2 (class levels)</td><td>--</td><td>1</td><td>2-4</td><td>5-10</td><td>11 or higher</td></tr><tr class=\"alt\"><td>Aligned magic item or spell (caster level)</td><td>5th or lower</td><td>6th-10th</td><td>11th-15th</td><td>16th-20th</td><td>21st or higher</td></tr></table><i>1 Except for undead and outsiders, which have their own entries on the table.</i><i>2 Some characters who are not clerics may radiate an aura of equivalent power. The class description will indicate whether this applies.</i>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 10 min./ level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Good")->setLongDescription(
            "This spell functions like <a href=\"Detect Evil\">detect evil</a>, except that it detects the auras of good creatures, clerics or paladins of good deities, good spells, and good magic items, and you are vulnerable to an overwhelming good aura if you are evil."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 10 min./ level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Law")->setLongDescription(
            "This spell functions like <a href=\"Detect Evil\">detect evil</a>, except that it detects the auras of lawful creatures, clerics of lawful deities, lawful spells, and lawful magic items, and you are vulnerable to an overwhelming lawful aura if you are chaotic."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 10 min./ level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Magic")->setLongDescription(
            "You detect magical auras. The amount of information revealed depends on how long you study a particular area or subject. 1st Round: Presence or absence of magical auras. 2nd Round: Number of different magical auras and the power of the most potent aura. 3rd Round: The strength and location of each aura. If the items or creatures bearing the auras are in line of sight, you can make Knowledge (arcana) skill checks to determine the school of magic involved in each. (Make one check per aura: DC 15 + spell level, or 15 + 1/2 caster level for a nonspell effect.) If the aura eminates from a magic item, you can attempt to identify its properties (see Spellcraft). Magical areas, multiple types of magic, or strong local magical emanations may distort or conceal weaker auras. Aura Strength: An aura's power depends on a spell's functioning spell level or an item's caster level; see the accompanying table. If an aura falls into more than one category, detect magic indicates the stronger of the two. Lingering Aura: A magical aura lingers after its original source dissipates (in the case of a spell) or is destroyed (in the case of a magic item). If detect magic is cast and directed at such a location, the spell indicates an aura strength of dim (even weaker than a faint aura). How long the aura lingers at this dim level depends on its original power: <table><tr><th>Original Strength</th><th>Duration of Lingering Aura</th></tr><tr><td>Faint</td><td>1d6 rounds</td></tr><tr class=\"alt\"><td>Moderate</td><td>1d6 minutes</td></tr><tr><td>Strong</td><td>1d6 x 10 minutes</td></tr><tr class=\"alt\"><td>Overwhelming</td><td>1d6 days</td></tr></table> Outsiders and elementals are not magical in themselves, but if they are summoned, the conjuration spell registers. Each round, you can turn to detect magic in a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it. Detect magic can be made permanent with a <a href=\"Permanency\">permanency</a> spell. <table><tr><th rowspan=\"2\">Spell or Object</th><th colspan=\"5\">Aura Power</th></tr><tr><th>Faint</th><th>Moderate</th><th>Strong</th><th>Overwhelming</th></tr><tr><td>Functioning spell (spell level)</td><td>3rd or lower</td><td>4th-6th</td><td>7th-9th</td><td>10th+ (deity-level)</td></tr><tr class=\"alt\"><td>Magic item (caster level)</td><td>5th or lower</td><td>6th-11th</td><td>12th-20th</td><td>21st+ (artifact)</td></tr></table>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Poison")->setLongDescription(
            "You determine whether a creature, object, or area has been poisoned or is poisonous. You can determine the exact type of poison with a DC 20 Wisdom check. A character with the Craft (alchemy) skill may try a DC 20 Craft (alchemy) check if the Wisdom check fails, or may try the Craft (alchemy) check prior to the Wisdom check. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature, one object")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Scrying")->setLongDescription(
            "You immediately become aware of any attempt to observe you by means of a <a href=\"Divination\">divination</a> (scrying) spell or effect. The spell's area radiates from you and moves as you move. You know the location of every magical sensor within the spell's area. If the scrying attempt originates within the area, you also know its location; otherwise, you and the scrier immediately make opposed caster level checks (1d20 + caster level). If you at least match the scrier's result, you get a visual image of the scrier and an accurate sense of his direction and distance from you."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of mirror and a miniature brass hearing trumpet"
            )->setRange("40 ft.")->setTargets("")->setDuration("24 hours")->setSavingThrow("none")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Secret Doors")->setLongDescription(
            "You can detect secret doors, compartments, caches, and so forth. Only passages, doors, or openings that have been specifically constructed to escape detection are detected by this spell. The amount of information revealed depends on how long you study a particular area or subject. 1st Round: Presence or absence of secret doors. 2nd Round: Number of secret doors and the location of each. If an aura is outside your line of sight, then you discern its direction but not its exact location. Each Additional Round: The mechanism or trigger for one particular secret portal closely examined by you. Each round, you can turn to detect secret doors in a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Snares and Pits")->setLongDescription(
            "You can detect simple pits, deadfalls, and snares as well as mechanical traps constructed of natural materials. The spell does not detect complex traps, including trapdoor traps. Detect snares and pits does detect certain natural hazards--quicksand (a snare), a sinkhole (a pit), or unsafe walls of natural rock (a deadfall). It does not reveal other potentially dangerous conditions. The spell does not detect magic traps (except those that operate by pit, deadfall, or snaring; see the spell snare), nor mechanically complex ones, nor those that have been rendered safe or inactive. The amount of information revealed depends on how long you study a particular area. 1st Round: Presence or absence of hazards. 2nd Round: Number of hazards and the location of each. If a hazard is outside your line of sight, then you discern its direction but not its exact location. Each Additional Round: The general type and trigger for one particular hazard closely examined by you. Each round, you can turn to examine a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "concentration, up to 10 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Thoughts")->setLongDescription(
            "You detect surface thoughts. The amount of information revealed depends on how long you study a particular area or subject. 1st Round: Presence or absence of thoughts (from conscious creatures with Intelligence scores of 1 or higher). 2nd Round: Number of thinking minds and the Intelligence score of each. If the highest Intelligence is 26 or higher (and at least 10 points higher than your own Intelligence score), you are stunned for 1 round and the spell ends. This spell does not let you determine the location of the thinking minds if you can't see the creatures whose thoughts you are detecting. 3rd Round: Surface thoughts of any mind in the area. A target's Will save prevents you from reading its thoughts, and you must cast detect thoughts again to have another chance. Creatures of animal intelligence (Int 1 or 2) have simple, instinctual thoughts. Each round, you can turn to detect thoughts in a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it."
        )->setCastingTime("1 standard action")->setComponents("a copper piece")->setRange("60 ft.")->setTargets(
                ""
            )->setDuration("concentration, up to 1 min./level (D)")->setSavingThrow("Will negates")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Detect Undead")->setLongDescription(
            "You can detect the aura that surrounds undead creatures. The amount of information revealed depends on how long you study a particular area. 1st Round: Presence or absence of undead auras. 2nd Round: Number of undead auras in the area and the strength of the strongest undead aura present. If you are of good alignment, and the strongest undead aura's strength is overwhelming (see below), and the creature has HD of at least twice your character level, you are stunned for 1 round and the spell ends. 3rd Round: The strength and location of each undead aura. If an aura is outside your line of sight, then you discern its direction but not its exact location. Aura Strength: The strength of an undead aura is determined by the HD of the undead creature, as given on the table below. Lingering Aura: An undead aura lingers after its original source is destroyed. If detect undead is cast and directed at such a location, the spell indicates an aura strength of dim (even weaker than a faint aura). How long the aura lingers at this dim level depends on its original power, as given on the table below. <table><tr><th>HD</th><th>Strength</th><th>Lingering Aura Duration</th></tr><tr><td>1 or lower</td><td>Faint</td><td>1d6 rounds</td></tr><tr class=\"alt\"><td>2-4</td><td>Moderate</td><td>1d6 minutes</td></tr><tr><td>5-10</td><td>Strong</td><td>1d6 x 10 minutes</td></tr><tr class=\"alt\"><td>11 or higher</td><td>Overwhelming</td><td>1d6 days</td></tr></table> Each round, you can turn to detect undead in a new area. The spell can penetrate barriers, but 1 foot of stone, 1 inch of common metal, a thin sheet of lead, or 3 feet of wood or dirt blocks it."
        )->setCastingTime("1 standard action")->setComponents("earth from a grave")->setRange("60 ft.")->setTargets(
                ""
            )->setDuration("concentration, up to 1 minute/ level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dictum")->setLongDescription(
            "Any nonlawful creature within the area of a dictum spell suffers the following ill effects. <table><tr><th>HD</th><th>Effect</th></tr><tr><td>Equal to caster level</td><td>Deafened</td></tr><tr class=\"alt\"><td>Up to caster level -1</td><td>Staggered, deafened</td></tr><tr><td>Up to caster level -5</td><td>Paralyzed, staggered, deafened</td></tr><tr class=\"alt\"><td>Up to caster level -10</td><td>Killed, paralyzed, staggered, deafened</td></tr></table> The effects are cumulative and concurrent. A successful Will save reduces or eliminates these effects. Creatures affected by multiple effects make only one save and apply the result to all the effects. Deafened: The creature is deafened for 1d4 rounds. Save negates. Staggered: The creature is staggered for 2d4 rounds. Save reduces the staggered effect to 1d4 rounds. Paralyzed: The creature is paralyzed and helpless for 1d10 minutes. Save reduces the paralyzed effect to 1 round. Killed: Living creatures die. Undead creatures are destroyed. Save negates. If the save is successful, the creature instead takes 3d6 points of damage + 1 point per caster level (maximum +25). Furthermore, if you are on your home plane when you cast this spell, nonlawful extraplanar creatures within the area are instantly banished back to their home planes. Creatures so banished cannot return for at least 24 hours. This effect takes place regardless of whether the creatures hear the dictum or not. The banishment effect allows a Will save (at a -4 penalty) to negate. Creatures whose Hit Dice exceed your caster level are unaffected by dictum."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("40 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("none or Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dimensional Anchor")->setLongDescription(
            "A green ray springs from your hand. You must make a ranged touch attack to hit the target. Any creature or object struck by the ray is covered with a shimmering emerald field that completely blocks extradimensional travel. Forms of movement barred by a dimensional anchor include <a href=\"Astral Projection\">astral projection</a>, <a href=\"Blink\">blink</a>, <a href=\"Dimension Door\">dimension door</a>, <a href=\"Ethereal Jaunt\">ethereal jaunt</a>, <a href=\"Etherealness\">etherealness</a>, <a href=\"Gate\">gate</a>, <a href=\"Maze\">maze</a>, <a href=\"Plane Shift\">plane shift</a>, <a href=\"Shadow Walk\">shadow walk</a>, <a href=\"Teleport\">teleport</a>, and similar spell-like abilities. The spell also prevents the use of a <a href=\"Gate\">gate</a> or <a href=\"Teleportation Circle\">teleportation circle</a> for the duration of the spell. A dimensional anchor does not interfere with the movement of creatures already in ethereal or astral form when the spell is cast, nor does it block extradimensional perception or attack forms. Also, dimensional anchor does not prevent summoned creatures from disappearing at the end of a summoning spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dimensional Lock")->setLongDescription(
            "You create a shimmering emerald barrier that completely blocks extradimensional travel. Forms of movement barred include <a href=\"Astral Projection\">astral projection</a>, <a href=\"Blink\">blink</a>, <a href=\"Dimension Door\">dimension door</a>, <a href=\"Ethereal Jaunt\">ethereal jaunt</a>, <a href=\"Etherealness\">etherealness</a>, <a href=\"Gate\">gate</a>, <a href=\"Maze\">maze</a>, <a href=\"Plane Shift\">plane shift</a>, <a href=\"Shadow Walk\">shadow walk</a>, <a href=\"Teleport\">teleport</a>, and similar spell-like abilities. Once dimensional lock is in place, extradimensional travel into or out of the area is not possible. A dimensional lock does not interfere with the movement of creatures already in ethereal or astral form when the spell is cast, nor does it block extradimensional perception or attack forms. Also, the spell does not prevent summoned creatures from disappearing at the end of a summoning spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 day/level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dimension Door")->setLongDescription(
            "You instantly transfer yourself from your current location to any other spot within range. You always arrive at exactly the spot desired--whether by simply visualizing the area or by stating direction. After using this spell, you can't take any other actions until your next turn. You can bring along objects as long as their weight doesn't exceed your maximum load. You may also bring one additional willing Medium or smaller creature (carrying gear or objects up to its maximum load) or its equivalent per three caster levels. A Large creature counts as two Medium creatures, a Huge creature counts as two Large creatures, and so forth. All creatures to be transported must be in contact with one another, and at least one of those creatures must be in contact with you. If you arrive in a place that is already occupied by a solid body, you and each creature traveling with you take 1d6 points of damage and are shunted to a random open space on a suitable surface within 100 feet of the intended location. If there is no free space within 100 feet, you and each creature traveling with you take an additional 2d6 points of damage and are shunted to a free space within 1,000 feet. If there is no free space within 1,000 feet, you and each creature travelling with you take an additional 4d6 points of damage and the spell simply fails."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("you and touched objects or other touched willing creatures")->setDuration(
                "instantaneous"
            )->setSavingThrow("none and Will negates (object)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Diminish Plants")->setLongDescription(
            "This spell has two versions. Prune Growth: This version of the spell causes normal vegetation within long range (400 feet + 40 feet per level) to shrink to about one-third normal size, becoming untangled and less bushy. The affected vegetation appears to have been carefully pruned and trimmed. This version of diminish plants automatically dispels any spells or effects that enhance plants, such as <a href=\"Entangle\">entangle</a>, <a href=\"Plant Growth\">plant growth</a>, and <a href=\"Wall of Thorns\">wall of thorns</a>. At your option, the area can be a 100-foot-radius circle, a 150-foot-radius semicircle, or a 200-foot-radius quarter-circle. You may also designate portions of the area that are not affected. Stunt Growth: This version of the spell targets all normal plants within a range of 1/2 mile, reducing their potential productivity over the course of the following year to half normal.  This spell has no effect on plant creatures."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets(
                "see text"
            )->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Discern Lies")->setLongDescription(
            "Each round, you concentrate on one target, who must be within range. You know if the target deliberately and knowingly speaks a lie by discerning disturbances in its aura caused by lying. The spell does not reveal the truth, uncover unintentional inaccuracies, or necessarily reveal evasions. Each round, you may concentrate on a different target."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "concentration, up to 1 round/level"
            )->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Discern Location")->setLongDescription(
            "A discern location spell is among the most powerful means of locating creatures or objects. Nothing short of a <a href=\"Mind Blank\">mind blank</a> spell or the direct intervention of a deity keeps you from learning the exact location of a single individual or object. Discern location circumvents normal means of protection from scrying or location. The spell reveals the name of the creature or object's location (place, name, business name, building name, or the like), community, county (or similar political division), country, continent, and the plane of existence where the target lies. To find a creature with the spell, you must have seen the creature or have some item that once belonged to it. To find an object, you must have touched it at least once."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("unlimited")->setTargets(
                "one creature or object"
            )->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Disguise Self")->setLongDescription(
            "You make yourself--including clothing, armor, weapons, and equipment--look different. You can seem 1 foot shorter or taller, thin, fat, or in between. You cannot change your creature type (although you can appear as another subtype). Otherwise, the extent of the apparent change is up to you. You could add or obscure a minor feature or look like an entirely different person or gender. The spell does not provide the abilities or mannerisms of the chosen form, nor does it alter the perceived tactile (touch) or audible (sound) properties of you or your equipment. If you use this spell to create a disguise, you get a +10 bonus on the Disguise check. A creature that interacts with the glamer gets a Will save to recognize it as an illusion."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "10 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Disintegrate")->setLongDescription(
            "A thin, green ray springs from your pointing finger. You must make a successful ranged touch attack to hit. Any creature struck by the ray takes 2d6 points of damage per caster level (to a maximum of 40d6). Any creature reduced to 0 or fewer hit points by this spell is entirely disintegrated, leaving behind only a trace of fine dust. A disintegrated creature's equipment is unaffected. When used against an object, the ray simply disintegrates as much as a 10-foot cube of nonliving matter. Thus, the spell disintegrates only part of any very large object or structure targeted. The ray affects even objects constructed entirely of force, such as <a href=\"Forceful Hand\">forceful hand</a> or a <a href=\"Wall of Force\">wall of force</a>, but not magical effects such as a <a href=\"Globe of Invulnerability\">globe of invulnerability</a> or an <a href=\"Antimagic Field\">antimagic field</a>. A creature or object that makes a successful Fortitude save is partially affected, taking only 5d6 points of damage. If this damage reduces the creature or object to 0 or fewer hit points, it is entirely disintegrated. Only the first creature or object struck can be affected; that is, the ray affects only one target per casting."
        )->setCastingTime("1 standard action")->setComponents("a lodestone and a pinch of dust")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow(
                "Fortitude partial (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dismissal")->setLongDescription(
            "This spell forces an extraplanar creature back to its proper plane if it fails a Will save. If the spell is successful, the creature is instantly whisked away, but there is a 20% chance of actually sending the subject to a plane other than its own."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one extraplanar creature")->setDuration("instantaneous")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dispel Chaos")->setLongDescription(
            "This spell functions like <a href=\"Dispel Evil\">dispel evil</a>, except that you are surrounded by constant, blue lawful energy, and the spell affects chaotic creatures and spells rather than evil ones."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "you and a touched evil creature from another plane, or you and an enchantment or evil spell on a touched creature or object"
            )->setDuration("1 round/level or until discharged, whichever comes first")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dispel Evil")->setLongDescription(
            "Shimmering, white holy energy surrounds you. This energy has three effects. First, you gain a +4 deflection bonus to AC against attacks by evil creatures. Second, on making a successful melee touch attack against an evil creature from another plane, you can choose to drive that creature back to its home plane. The creature can negate the effects with a successful Will save (spell resistance applies). This use discharges and ends the spell. Third, with a touch you can automatically dispel any one enchantment spell cast by an evil creature or any one evil spell. Spells that can't be dispelled by <a href=\"Dispel Magic\">dispel magic</a> also can't be dispelled by dispel evil. Saving throws and spell resistance do not apply to this effect. This use discharges and ends the spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "you and a touched evil creature from another plane, or you and an enchantment or evil spell on a touched creature or object"
            )->setDuration("1 round/level or until discharged, whichever comes first")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dispel Good")->setLongDescription(
            "This spell functions like <a href=\"Dispel Evil\">dispel evil</a>, except that you are surrounded by dark, wavering unholy energy, and the spell affects good creatures and spells rather than evil ones."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "you and a touched evil creature from another plane, or you and an enchantment or evil spell on a touched creature or object"
            )->setDuration("1 round/level or until discharged, whichever comes first")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dispel Law")->setLongDescription(
            "This spell functions like <a href=\"Dispel Evil\">dispel evil</a>, except that you are surrounded by flickering, yellow chaotic energy, and the spell affects lawful creatures and spells rather than evil ones."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "you and a touched evil creature from another plane, or you and an enchantment or evil spell on a touched creature or object"
            )->setDuration("1 round/level or until discharged, whichever comes first")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dispel Magic")->setLongDescription(
            "You can use dispel magic to end one ongoing spell that has been cast on a creature or object, to temporarily suppress the magical abilities of a magic item, or to counter another spellcaster's spell. A dispelled spell ends as if its duration had expired. Some spells, as detailed in their descriptions, can't be defeated by dispel magic. Dispel magic can dispel (but not counter) spell-like effects just as it does spells. The effect of a spell with an instantaneous duration can't be dispelled, because the magical effect is already over before the dispel magic can take effect.  You choose to use dispel magic in one of two ways: a targeted dispel or a counterspell. Targeted Dispel: One object, creature, or spell is the target of the dispel magic spell. You make one dispel check (1d20 + your caster level) and compare that to the spell with highest caster level (DC = 11 + the spell's caster level). If successful, that spell ends. If not, compare the same result to the spell with the next highest caster level. Repeat this process until you have dispelled one spell affecting the target, or you have failed to dispel every spell.  For example, a 7th-level caster casts dispel magic, targeting a creature affected by <a href=\"Stoneskin\">stoneskin</a> (caster level 12th) and <a href=\"Fly\">fly</a> (caster level 6th). The caster level check results in a 19. This check is not high enough to end the <a href=\"Stoneskin\">stoneskin</a> (which would have required a 23 or higher), but it is high enough to end the <a href=\"Fly\">fly</a> (which only required a 17). Had the dispel check resulted in a 23 or higher, the stoneskin would have been dispelled, leaving the fly intact. Had the dispel check been a 16 or less, no spells would have been affected. You can also use a targeted dispel to specifically end one spell affecting the target or one spell affecting an area (such as a wall of fire). You must name the specific spell effect to be targeted in this way. If your caster level check is equal to or higher than the DC of that spell, it ends. No other spells or effects on the target are dispelled if your check is not high enough to end the targeted effect. If you target an object or creature that is the effect of an ongoing spell (such as a monster summoned by summon monster), you make a dispel check to end the spell that conjured the object or creature. If the object that you target is a magic item, you make a dispel check against the item's caster level (DC = 11 + the item's caster level). If you succeed, all the item's magical properties are suppressed for 1d4 rounds, after which the item recovers its magical properties. A suppressed item becomes nonmagical for the duration of the effect. An interdimensional opening (such as a bag of holding) is temporarily closed. A magic item's physical properties are unchanged: A suppressed magic sword is still a sword (a masterwork sword, in fact). Artifacts and deities are unaffected by mortal magic such as this. You automatically succeed on your dispel check against any spell that you cast yourself. Counterspell: When dispel magic is used in this way, the spell targets a spellcaster and is cast as a counterspell. Unlike a true counterspell, however, dispel magic may not work; you must make a dispel check to counter the other spellcaster's spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one spellcaster, creature, or object")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dispel Magic, Greater")->setLongDescription(
            "This spell functions like <a href=\"Dispel Magic\">dispel magic</a>, except that it can end more than one spell on a target and it can be used to target multiple creatures.  You choose to use greater dispel magic in one of three ways: a targeted dispel, area dispel, or a counterspell: Targeted Dispel: This functions as a targeted <a href=\"Dispel Magic\">dispel magic</a>, but it can dispel one spell for every four caster levels you possess, starting with the highest level spells and proceeding to lower level spells. Additionally, greater dispel magic has a chance to dispel any effect that <a href=\"Remove Curse\">remove curse</a> can remove, even if <a href=\"Dispel Magic\">dispel magic</a> can't dispel that effect. The DC of this check is equal to the curse's DC. Area Dispel: When greater dispel magic is used in this way, the spell affects everything within a 20-foot-radius burst. Roll one dispel check and apply that check to each creature in the area, as if targeted by <a href=\"Dispel Magic\">dispel magic</a>. For each object within the area that is the target of one or more spells, apply the dispel check as with creatures. Magic items are not affected by an area dispel. For each ongoing area or effect spell whose point of origin is within the area of the greater dispel magic spell, apply the dispel check to dispel the spell. For each ongoing spell whose area overlaps that of the greater dispel magic spell, apply the dispel check to end the effect, but only within the overlapping area. If an object or creature that is the effect of an ongoing spell (such as a monster summoned by summon monster) is in the area, apply the dispel check to end the spell that conjured that object or creature (returning it whence it came) in addition to attempting to dispel one spell targeting the creature or object. You may choose to automatically succeed on dispel checks against any spell that you have cast. Counterspell: This functions as <a href=\"Dispel Magic\">dispel magic</a>, but you receive a +4 bonus on your dispel check to counter the other spellcaster's spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one spellcaster, creature, or object")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Displacement")->setLongDescription(
            "The subject of this spell appears to be about 2 feet away from its true location. The creature benefits from a 50% miss chance as if it had total concealment. Unlike actual total concealment, displacement does not prevent enemies from targeting the creature normally. True seeing reveals its true location and negates the miss chance."
        )->setCastingTime("1 standard action")->setComponents("a small loop of leather")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 round/level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Disrupting Weapon")->setLongDescription(
            "This spell makes a melee weapon deadly to undead. Any undead creature with HD equal to or less than your caster level must succeed on a Will save or be destroyed utterly if struck in combat with this weapon. Spell resistance does not apply against the destruction effect."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one melee weapon"
            )->setDuration("1 round/level")->setSavingThrow("Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Disrupt Undead")->setLongDescription(
            "You direct a ray of positive energy. You must make a ranged touch attack to hit, and if the ray hits an undead creature, it deals 1d6 points of damage to it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Divination")->setLongDescription(
            "Similar to <a href=\"Augury\">augury</a> but more powerful, a divination spell can provide you with a useful piece of advice in reply to a question concerning a specific goal, event, or activity that is to occur within 1 week. The advice granted by the spell can be as simple as a short phrase, or it might take the form of a cryptic rhyme or omen. If your party doesn't act on the information, the conditions may change so that the information is no longer useful. The base chance for a correct divination is 70% + 1% per caster level, to a maximum of 90%. If the die roll fails, you know the spell failed, unless specific magic yielding false information is at work. As with <a href=\"Augury\">augury</a>, multiple divinations about the same topic by the same caster use the same dice result as the first divination spell and yield the same answer each time."
        )->setCastingTime("10 minutes")->setComponents("incense and an appropriate offering worth 25 gp")->setRange(
                "personal"
            )->setTargets("you")->setDuration("instantaneous")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Divine Favor")->setLongDescription(
            "Calling upon the strength and wisdom of a deity, you gain a +1 luck bonus on attack and weapon damage rolls for every three caster levels you have (at least +1, maximum +3). The bonus doesn't apply to spell damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 minute"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Divine Power")->setLongDescription(
            "Calling upon the divine power of your patron, you imbue yourself with strength and skill in combat. You gain a +1 luck bonus on attack rolls, weapon damage rolls, Strength checks, and Strength-based skill checks for every three caster levels you have (maximum +6). You also gain 1 temporary hit point per caster level. Whenever you make a full-attack action, you can make an additional attack at your full base attack bonus, plus any appropriate modifiers. This additional attack is not cumulative with similar effects, such as <a href=\"Haste\">haste</a> or weapons with the speed special ability."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 round/level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dominate Animal")->setLongDescription(
            "This spell allows you to enchant the targeted animal and direct it with simple commands such as Attack, Run, and Fetch. Suicidal or self-destructive commands (including an order to attack a creature two or more size categories larger than the dominated animal) are simply ignored. Dominate animal establishes a mental link between you and the subject creature. The animal can be directed by silent mental command as long as it remains in range. You need not see the creature to control it. You do not receive direct sensory input from the creature, but you know what it is experiencing. Because you are directing the animal with your own intelligence, it may be able to undertake actions normally beyond its own comprehension. You need not concentrate exclusively on controlling the creature unless you are trying to direct it to do something it normally couldn't do. Changing your instructions or giving a dominated creature a new command is the equivalent of redirecting a spell, so it is a move action."
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                "one animal"
            )->setDuration("1 round/level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dominate Monster")->setLongDescription(
            "This spell functions like <a href=\"Dominate Person\">dominate person</a>, except that the spell is not restricted by creature type."
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                "one creature"
            )->setDuration("1 day/level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dominate Person")->setLongDescription(
            "You can control the actions of any humanoid creature through a telepathic link that you establish with the subject's mind. If you and the subject have a common language, you can generally force the subject to perform as you desire, within the limits of its abilities. If no common language exists, you can communicate only basic commands, such as Come here, Go there, Fight, and Stand still. You know what the subject is experiencing, but you do not receive direct sensory input from it, nor can it communicate with you telepathically. Once you have given a dominated creature a command, it continues to attempt to carry out that command to the exclusion of all other activities except those necessary for day-to-day survival (such as sleeping, eating, and so forth). Because of this limited range of activity, a Sense Motive check against DC 15 (rather than DC 25) can determine that the subject's behavior is being influenced by an enchantment effect (see the Sense Motive skill description). Changing your orders or giving a dominated creature a new command is a move action. By concentrating fully on the spell (a standard action), you can receive full sensory input as interpreted by the mind of the subject, though it still can't communicate with you. You can't actually see through the subject's eyes, so it's not as good as being there yourself, but you still get a good idea of what's going on. Subjects resist this control, and any subject forced to take actions against its nature receives a new saving throw with a +2 bonus. Obviously self-destructive orders are not carried out. Once control is established, the range at which it can be exercised is unlimited, as long as you and the subject are on the same plane. You need not see the subject to control it. If you don't spend at least 1 round concentrating on the spell each day, the subject receives a new saving throw to throw off the domination. Protection from evil or a similar spell can prevent you from exercising control or using the telepathic link while the subject is so warded, but such an effect does not automatically dispel it."
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                "one humanoid"
            )->setDuration("1 day/level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Doom")->setLongDescription(
            "This spell fills a single subject with a feeling of horrible dread that causes it to become shaken."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one living creature")->setDuration("1 min./level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Dream")->setLongDescription(
            "You, or a messenger you touch, send a message to others in the form of a dream. At the beginning of the spell, you must name the recipient or identify him or her by some title that leaves no doubt as to identity. The messenger then enters a trance, appears in the intended recipient's dream, and delivers the message. The message can be of any length, and the recipient remembers it perfectly upon waking. The communication is one-way. The recipient cannot ask questions or offer information, nor can the messenger gain any information by observing the dreams of the recipient. Once the message is delivered, the messenger's mind returns instantly to its body. The duration of the spell is the time required for the messenger to enter the recipient's dream and deliver the message. If the recipient is awake when the spell begins, the messenger can choose to wake up (ending the spell) or remain in the trance. The messenger can remain in the trance until the recipient goes to sleep, then enter the recipient's dream and deliver the message as normal. A messenger that is disturbed during the trance comes awake, ending the spell. Creatures who don't sleep or don't dream cannot be contacted by this spell. The messenger is unaware of its own surroundings or of the activities around it while in the trance. It is defenseless both physically and mentally (always failing any saving throw) while in the trance."
        )->setCastingTime("1 minute")->setComponents("")->setRange("unlimited")->setTargets(
                "one living creature touched"
            )->setDuration("see text")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Eagle's Splendor")->setLongDescription(
            "The transmuted creature becomes more poised, articulate, and personally forceful. The spell grants a +4 enhancement bonus to Charisma, adding the usual benefits to Charisma-based skill checks and other uses of the Charisma modifier. Bards, paladins, and sorcerers (and other spellcasters who rely on Charisma) affected by this spell do not gain any additional bonus spells for the increased Charisma, but the save DCs for spells they cast while under this spell's effect do increase."
        )->setCastingTime("1 standard action")->setComponents("feathers or droppings from an eagle")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Eagle's Splendor, Mass")->setLongDescription(
            "This spell functions like <a href=\"Eagle's Splendor\">eagle's splendor</a>, except that it affects multiple creatures."
        )->setCastingTime("1 standard action")->setComponents("feathers or droppings from an eagle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("One creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Earthquake")->setLongDescription(
            "When you cast earthquake, an intense but highly localized tremor rips the ground. The powerful shockwave created by this spell knocks creatures down, collapses structures, opens cracks in the ground, and more. The effect lasts for 1 round, during which time creatures on the ground can't move or attack. A spellcaster on the ground must make a Concentration check (DC 20 + spell level) or lose any spell he or she tries to cast. The earthquake affects all terrain, vegetation, structures, and creatures in the area. The specific effect of an earthquake spell depends on the nature of the terrain where it is cast. Cave, Cavern, or Tunnel: The roof collapses, dealing 8d6 points of damage to any creature caught under the cave-in (Reflex DC 15 half) and pinning that creature beneath the rubble (see below). An earthquake cast on the roof of a very large cavern could also endanger those outside the actual area but below the falling debris and rubble. Cliffs: Earthquake causes a cliff to crumble, creating a landslide that travels horizontally as far as it falls vertically. Any creature in the path takes 8d6 points of bludgeoning damage (Reflex DC 15 half) and is pinned beneath the rubble (see below). Open Ground: Each creature standing in the area must make a DC 15 Reflex save or fall down. Fissures open in the earth, and every creature on the ground has a 25% chance to fall into one (Reflex DC 20 to avoid a fissure). The fissures are 40 feet deep. At the end of the spell, all fissures grind shut. Treat all trapped creatures as if they were in the bury zone of an avalanche, trapped without air (see Environment for more details). Structure: Any structure standing on open ground takes 100 points of damage, enough to collapse a typical wooden or masonry building, but not a structure built of stone or reinforced masonry. Hardness does not reduce this damage, nor is it halved as damage dealt to objects normally is. Any creature caught inside a collapsing structure takes 8d6 points of bludgeoning damage (Reflex DC 15 half) and is pinned beneath the rubble (see below). River, Lake, or Marsh: Fissures open under the water, draining away the water from that area and forming muddy ground. Soggy marsh or swampland becomes quicksand for the duration of the spell, sucking down creatures and structures. Each creature in the area must make a DC 15 Reflex save or sink down in the mud and quicksand. At the end of the spell, the rest of the body of water rushes in to replace the drained water, possibly drowning those caught in the mud. Pinned Beneath Rubble: Any creature pinned beneath rubble takes 1d6 points of nonlethal damage per minute while pinned. If a pinned character falls unconscious, he or she must make a DC 15 Constitution check or take 1d6 points of lethal damage each minute thereafter until freed or dead."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 round")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Elemental Body 1")->setLongDescription(
            "When you cast this spell, you can assume the form of a Small air, earth, fire, or water elemental. The abilities you gain depend upon the type of elemental into which you change. Elemental abilities based on size, such as burn, vortex, and whirlwind, use the size of the elemental you transform into to determine their effect. Air elemental: If the form you take is that of a Small air elemental, you gain a +2 size bonus to your Dexterity and a +2 natural armor bonus. You also gain fly 60 feet (perfect), darkvision 60 feet, and the ability to create a whirlwind. Earth elemental: If the form you take is that of a Small earth elemental, you gain a +2 size bonus to your Strength and a +4 natural armor bonus. You also gain darkvision 60 feet, the push ability, and the ability to earth glide. Fire elemental: If the form you take is that of a Small fire elemental, you gain a +2 size bonus to your Dexterity and a +2 natural armor bonus. You gain darkvision 60 feet, resist fire 20, vulnerability to cold, and the burn ability. Water elemental: If the form you take is that of a Small water elemental, you gain a +2 size bonus to your Constitution and a +4 natural armor bonus. You also gain swim 60 feet, darkvision 60 feet, the ability to create a vortex, and the ability to breathe water."
        )->setCastingTime("1 standard action")->setComponents("the element you plan to assume")->setRange(
                "personal"
            )->setTargets("you")->setDuration("1 min/level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Elemental Body 2")->setLongDescription(
            "This spell functions as <a href=\"Elemental Body I\">elemental body I</a>, except that it also allows you to assume the form of a Medium air, earth, fire, or water elemental. The abilities you gain depend upon the elemental. Air elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Dexterity and a +3 natural armor bonus.  Earth elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Strength and a +5 natural armor bonus.  Fire elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Dexterity and a +3 natural armor bonus. Water elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Constitution and a +5 natural armor bonus. "
        )->setCastingTime("1 standard action")->setComponents("the element you plan to assume")->setRange(
                "personal"
            )->setTargets("you")->setDuration("1 min/level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Elemental Body 3")->setLongDescription(
            "This spell functions as <a href=\"Elemental Body II\">elemental body II</a>, except that it also allows you to assume the form of a Large air, earth, fire, or water elemental. The abilities you gain depend upon the type of elemental into which you change. You are also immune to critical hits and sneak attacks while in elemental form. Air elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +2 size bonus to your Strength, +4 size bonus to your Dexterity, and a +4 natural armor bonus.  Earth elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +6 size bonus to your Strength, a -2 penalty on your Dexterity, a +2 size bonus to your Constitution, and a +6 natural armor bonus.  Fire elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Dexterity, a +2 size bonus to your Constitution, and a +4 natural armor bonus. Water elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +2 size bonus to your Strength, a -2 penalty on your Dexterity, a +6 size bonus to your Constitution, and a +6 natural armor bonus. "
        )->setCastingTime("1 standard action")->setComponents("the element you plan to assume")->setRange(
                "personal"
            )->setTargets("you")->setDuration("1 min/level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Elemental Body 4")->setLongDescription(
            "This spell functions as <a href=\"Elemental Body III\">elemental body III</a>, except that it also allows you to assume the form of a Huge air, earth, fire, or water elemental. The abilities you gain depend upon the type of elemental into which you change. You are also immune to critical hits and sneak attacks while in elemental form and gain DR 5/--. Air elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Strength, +6 size bonus to your Dexterity, and a +4 natural armor bonus. You also gain fly 120 feet (perfect). Earth elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +8 size bonus to your Strength, a -2 penalty on your Dexterity, a +4 size bonus to your Constitution, and a +6 natural armor bonus.  Fire elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +6 size bonus to your Dexterity, a +4 size bonus to your Constitution, and a +4 natural armor bonus. Water elemental: As <a href=\"Elemental Body I\">elemental body I</a> except that you gain a +4 size bonus to your Strength, a -2 penalty on your Dexterity, a +8 size bonus to your Constitution, and a +6 natural armor bonus. You also gain swim 120 feet."
        )->setCastingTime("1 standard action")->setComponents("the element you plan to assume")->setRange(
                "personal"
            )->setTargets("you")->setDuration("1 min/level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Elemental Swarm")->setLongDescription(
            "This spell opens a portal to an Elemental Plane and summons elementals from it. A druid can choose any plane (Air, Earth, Fire, or Water); a cleric opens a portal to the plane matching his domain. When the spell is complete, 2d4 Large elementals appear. Ten minutes later, 1d4 Huge elementals appear. Ten minutes after that, one greater elemental appears. Each elemental has maximum hit points per HD. Once these creatures appear, they serve you for the duration of the spell. The elementals obey you explicitly and never attack you, even if someone else manages to gain control over them. You do not need to concentrate to maintain control over the elementals. You can dismiss them singly or in groups at any time. When you use a summoning spell to summon an air, earth, fire, or water creature, it is a spell of that type."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("medium (100 ft. + 10 ft./level)")->setTargets(
                ""
            )->setDuration("10 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Endure Elements")->setLongDescription(
            "A creature protected by endure elements suffers no harm from being in a hot or cold environment. It can exist comfortably in conditions between -50 and 140 degrees Fahrenheit without having to make Fortitude saves. The creature's equipment is likewise protected. Endure elements doesn't provide any protection from fire or cold damage, nor does it protect against other environmental hazards such as smoke, lack of air, and so forth."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("24 hours")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Energy Drain")->setLongDescription(
            "This spell functions like <a href=\"Enervation\">enervation</a>, except that the creature struck gains 2d4 temporary negative levels. Twenty-four hours after gaining them, the subject must make a Fortitude saving throw (DC = energy drain spell's save DC) for each negative level. If the save succeeds, that negative level is removed. If it fails, that negative level becomes permanent. An undead creature struck by the ray gains 2d4 x 5 temporary hit points for 1 hour."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Fortitude partial")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Enervation")->setLongDescription(
            "You point your finger and fire a black ray of negative energy that suppresses the life force of any living creature it strikes. You must make a ranged touch attack to hit. If you hit, the subject gains 1d4 temporary negative levels (see Special Abilities). Negative levels stack. Assuming the subject survives, it regains lost levels after a number of hours equal to your caster level (maximum 15 hours). Usually, negative levels have a chance of becoming permanent, but the negative levels from enervation don't last long enough to do so. An undead creature struck by the ray gains 1d4 x 5 temporary hit points for 1 hour."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Enlarge Person")->setLongDescription(
            "This spell causes instant growth of a humanoid creature, doubling its height and multiplying its weight by 8. This increase changes the creature's size category to the next larger one. The target gains a +2 size bonus to Strength, a -2 size penalty to Dexterity (to a minimum of 1), and a -1 penalty on attack rolls and AC due to its increased size. A humanoid creature whose size increases to Large has a space of 10 feet and a natural reach of 10 feet. This spell does not change the target's speed. If insufficient room is available for the desired growth, the creature attains the maximum possible size and may make a Strength check (using its increased Strength) to burst any enclosures in the process. If it fails, it is constrained without harm by the materials enclosing it--the spell cannot be used to crush a creature by increasing its size. All equipment worn or carried by a creature is similarly enlarged by the spell. Melee weapons affected by this spell deal more damage (see Table: Tiny and Large Weapon Damage). Other magical properties are not affected by this spell. Any enlarged item that leaves an enlarged creature's possession (including a projectile or thrown weapon) instantly returns to its normal size. This means that thrown and projectile weapons deal their normal damage. Magical properties of enlarged items are not increased by this spell. Multiple magical effects that increase size do not stack. Enlarge person counters and dispels <a href=\"Reduce Person\">reduce person</a>. Enlarge person can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 round")->setComponents("powdered iron")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one humanoid creature")->setDuration("1 min./level (D)")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Enlarge Person, Mass")->setLongDescription(
            "This spell functions like <a href=\"Enlarge Person\">enlarge person</a>, except that it affects multiple creatures."
        )->setCastingTime("1 round")->setComponents("powdered iron")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("One humanoid creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Entangle")->setLongDescription(
            "This spell causes tall grass, weeds, and other plants to wrap around foes in the area of effect or those that enter the area. Creatures that fail their save gain the entangled condition. Creatures that make their save can move as normal, but those that remain in the area must save again at the end of your turn. Creatures that move into the area must save immediately. Those that fail must end their movement and gain the entangled condition. Entangled creatures can attempt to break free as a move action, making a Strength or Escape Artist check. The DC for this check is equal to the DC of the spell. The entire area of effect is considered difficult terrain while the effect lasts. If the plants in the area are covered in thorns, those in the area take 1 point of damage each time they fail a save against the entangle or fail a check made to break free. Other effects, depending on the local plants, might be possible at GM discretion."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow(": Reflex partial")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Enthrall")->setLongDescription(
            "If you have the attention of a group of creatures, you can use this spell to hold them enthralled. To cast the spell, you must speak or sing without interruption for 1 full round. Thereafter, those affected give you their undivided attention, ignoring their surroundings. They are considered to have an attitude of friendly while under the effect of the spell. Any potentially affected creature of a race or religion unfriendly to yours gets a +4 bonus on the saving throw. A target with 4 or more HD or with a Wisdom score of 16 or higher remains aware of its surroundings and has an attitude of indifferent. It gains a new saving throw if it witnesses actions that it opposes. The effect lasts as long as you speak or sing, to a maximum of 1 hour. Those enthralled by your words take no action while you speak or sing and for 1d3 rounds thereafter while they discuss the topic or performance. Those entering the area during the performance must also successfully save or become enthralled. The speech ends (but the 1d3-round delay still applies) if you lose concentration or do anything other than speak or sing. If those not enthralled have unfriendly or hostile attitudes toward you, they can collectively make a Charisma check to try to end the spell by jeering and heckling. For this check, use the Charisma bonus of the creature with the highest Charisma in the group; others may make Charisma checks to assist. The heckling ends the spell if this check result beats your Charisma check result. Only one such challenge is allowed per use of the spell. If any member of the audience is attacked or subjected to some other overtly hostile act, the spell ends and the previously enthralled members become immediately unfriendly toward you. Each creature with 4 or more HD or with a Wisdom score of 16 or higher becomes hostile."
        )->setCastingTime("1 round")->setComponents("")->setRange("medium (100 ft. + 10 ft./level)")->setTargets(
                "any number of creatures"
            )->setDuration("1 hour or less")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Entropic Shield")->setLongDescription(
            "A magical field appears around you, glowing with a chaotic blast of multicolored hues. This field deflects incoming arrows, rays, and other ranged attacks. Each ranged attack directed at you for which the attacker must make an attack roll has a 20% miss chance (similar to the effects of concealment). Other attacks that simply work at a distance are not affected."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Erase")->setLongDescription(
            "Erase removes writings of either magical or mundane nature from a scroll or from one or two pages of paper, parchment, or similar surfaces. With this spell, you can remove <a href=\"Explosive Runes\">explosive runes</a>, a <a href=\"Glyph of Warding\">glyph of warding</a>, a <a href=\"Sepia Snake Sigil\">sepia snake sigil</a>, or an <a href=\"Arcane Mark\">arcane mark</a>, but not <a href=\"Illusory Script\">illusory script</a> or a symbol spell. Nonmagical writing is automatically erased if you touch it and no one else is holding it. Otherwise, the chance of erasing nonmagical writing is 90%. Magic writing must be touched to be erased, and you also must succeed on a caster level check (1d20 + caster level) against DC 15. A natural 1 is always a failure on this check. If you fail to erase <a href=\"Explosive Runes\">explosive runes</a>, a <a href=\"Glyph of Warding\">glyph of warding</a>, or a <a href=\"Sepia Snake Sigil\">sepia snake sigil</a>, you accidentally activate that writing instead."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one scroll or two pages")->setDuration("instantaneous")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ethereal Jaunt")->setLongDescription(
            "You become ethereal, along with your equipment. For the duration of the spell, you are in the Ethereal Plane, which overlaps the Material Plane. When the spell expires, you return to material existence. An ethereal creature is invisible, insubstantial, and capable of moving in any direction, even up or down, albeit at half normal speed. As an insubstantial creature, you can move through solid objects, including living creatures. An ethereal creature can see and hear on the Material Plane, but everything looks gray and ephemeral. Sight and hearing onto the Material Plane are limited to 60 feet. Force effects and abjurations affect an ethereal creature normally. Their effects extend onto the Ethereal Plane from the Material Plane, but not vice versa. An ethereal creature can't attack material creatures, and spells you cast while ethereal affect only other ethereal things. Certain material creatures or objects have attacks or effects that work on the Ethereal Plane. Treat other ethereal creatures and ethereal objects as if they were material.  If you end the spell and become material while inside a material object (such as a solid wall), you are shunted off to the nearest open space and take 1d6 points of damage per 5 feet that you so travel."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Etherealness")->setLongDescription(
            "This spell functions like <a href=\"Ethereal Jaunt\">ethereal jaunt</a>, except that you and other willing creatures joined by linked hands (along with their equipment) become ethereal. Besides yourself, you can bring one creature per three caster levels to the Ethereal Plane. Once ethereal, the subjects need not stay together. When the spell expires, all affected creatures on the Ethereal Plane return to material existence."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch; see text")->setTargets(
                "you and one other touched creature per three levels"
            )->setDuration("1 min./level (D)")->setSavingThrow("")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Expeditious Retreat")->setLongDescription(
            "This spell increases your base land speed by 30 feet. This adjustment is treated as an enhancement bonus. There is no effect on other modes of movement, such as burrow, climb, fly, or swim. As with any effect that increases your speed, this spell affects your jumping distance (see the Acrobatics skill)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Explosive Runes")->setLongDescription(
            "You trace mystic runes upon a book, map, scroll, or similar object bearing written information. The explosive runes detonate when read, dealing 6d6 points of force damage. Anyone next to the explosive runes (close enough to read them) takes the full damage with no saving throw; any other creature within 10 feet of the explosive runes is entitled to a Reflex save for half damage. The object on which the explosive runes were written also takes full damage (no saving throw). You and any characters you specifically instruct can read the protected writing without triggering the explosive runes. Likewise, you can remove the explosive runes whenever desired. Another creature can remove them with a successful <a href=\"Dispel Magic\">dispel magic</a> or <a href=\"Erase\">erase</a> spell, but attempting to dispel or erase the explosive runes and failing to do so triggers the explosion. Magic traps such as explosive runes are hard to detect and disable. A character with the trapfinding class feature (only) can use Disable Device to thwart explosive runes. The DC to find magic traps using Perception and to disable them is 25 + spell level, or 28 for explosive runes."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched object weighing no more than 10 lbs."
            )->setDuration("permanent until discharged (D)")->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Eyebite")->setLongDescription(
            "Each round, you can target a single living creature, striking it with waves of power. Depending on the target's HD, this attack has as many as three effects. <table><tr><th>HD</th><th>Effect</th></tr><tr class=\"alt\"><td>10 or more</td><td>Sickened</td></tr><tr><td>5-9</td><td>Panicked, sickened</td></tr><tr class=\"alt\"><td>4 or less</td><td>Comatose, panicked, sickened</td></tr></table>The effects are cumulative and concurrent. Sickened: Sudden pain and fever sweeps over the subject's body. A creature affected by this spell remains sickened for 10 minutes per caster level. The effects cannot be negated by a <a href=\"Remove Disease\">remove disease</a> or <a href=\"Heal\">heal</a> spell, but a <a href=\"Remove Curse\">remove curse</a> is effective. Panicked: The subject becomes panicked for 1d4 rounds. Even after the panic ends, the creature remains shaken for 10 minutes per caster level, and it automatically becomes panicked again if it comes within sight of you during that time. This is a fear effect. Comatose: The subject falls into a catatonic coma for 10 minutes per caster level. During this time, it cannot be awakened by any means short of dispelling the effect. This is not a sleep effect, and thus elves are not immune to it. You must spend a swift action each round after the first to target a foe."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("1 round/level")->setSavingThrow(
                ": Fortitude negates"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fabricate")->setLongDescription(
            "You convert material of one sort into a product that is of the same material. Creatures or magic items cannot be created or transmuted by the fabricate spell. The quality of items made by this spell is commensurate with the quality of material used as the basis for the new fabrication. If you work with a mineral, the target is reduced to 1 cubic foot per level instead of 10 cubic feet. You must make an appropriate Craft check to fabricate articles requiring a high degree of craftsmanship. Casting requires 1 round per 10 cubic feet of material to be affected by the spell."
        )->setCastingTime("see text")->setComponents(
                "the original material, which costs the same amount as the raw materials required to craft the item to be created"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("up to 10 cu. ft./level; see text")->setDuration(
                "instantaneous"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Faerie Fire")->setLongDescription(
            "A pale glow surrounds and outlines the subjects. Outlined subjects shed light as candles. Creatures outlined by faerie fire take a -20 penalty on all Stealth checks. Outlined creatures do not benefit from the concealment normally provided by darkness (though a 2nd-level or higher magical darkness effect functions normally), blur, displacement, invisibility, or similar effects. The light is too dim to have any special effect on undead or dark-dwelling creatures vulnerable to light. The faerie fire can be blue, green, or violet, according to your choice at the time of casting. The faerie fire does not cause any harm to the objects or creatures thus outlined."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("False Life")->setLongDescription(
            "You harness the power of unlife to grant yourself a limited ability to avoid death. While this spell is in effect, you gain temporary hit points equal to 1d10 + 1 per caster level (maximum +10)."
        )->setCastingTime("1 standard action")->setComponents("a drop of blood")->setRange("personal")->setTargets(
                "you"
            )->setDuration("1 hour/level or until discharged; see text")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("False Vision")->setLongDescription(
            "This spell creates a subtle illusion, causing any <a href=\"Divination\">divination</a> (scrying) spell used to view anything within the area of this spell to instead receive a false image (as the <a href=\"Major Image\">major image</a> spell), as defined by you at the time of casting. As long as the duration lasts, you can concentrate to change the image as desired. While you aren't concentrating, the image remains static."
        )->setCastingTime("1 standard action")->setComponents("crushed jade worth 250 gp")->setRange(
                "touch"
            )->setTargets("")->setDuration("1 hour/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fear")->setLongDescription(
            "An invisible cone of terror causes each living creature in the area to become panicked unless it succeeds on a Will save. If cornered, a panicked creature begins cowering. If the Will save succeeds, the creature is shaken for 1 round."
        )->setCastingTime("1 standard action")->setComponents("the heart of a hen or a white feather")->setRange(
                "30 ft."
            )->setTargets("")->setDuration("1 round/level or 1 round; see text")->setSavingThrow(
                "Will partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Feather Fall")->setLongDescription(
            "The affected creatures or objects fall slowly. Feather fall instantly changes the rate at which the targets fall to a mere 60 feet per round (equivalent to the end of a fall from a few feet), and the subjects take no damage upon landing while the spell is in effect. When the spell duration expires, a normal rate of falling resumes. The spell affects one or more Medium or smaller creatures (including gear and carried objects up to each creature's maximum load) or objects, or the equivalent in larger creatures: a Large creature or object counts as two Medium creatures or objects, a Huge creature or object counts as four Medium creatures or objects, and so forth. This spell has no special effect on ranged weapons unless they are falling quite a distance. If the spell is cast on a falling item, the object does half normal damage based on its weight, with no bonus for the height of the drop. Feather fall works only upon free-falling objects. It does not affect a sword blow or a charging or flying creature."
        )->setCastingTime("1 immediate action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "one Medium or smaller freefalling object or creature/level, no two of which may be more than 20 ft. apart"
            )->setDuration("until landing or 1 round/level")->setSavingThrow(
                "Will negates (harmless) or Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Feeblemind")->setLongDescription(
            "Target creature's Intelligence and Charisma scores each drop to 1. The affected creature is unable to use Intelligence- or Charisma-based skills, cast spells, understand language, or communicate coherently. Still, it knows who its friends are and can follow them and even protect them. The subject remains in this state until a <a href=\"Heal\">heal</a>, <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, or <a href=\"Wish\">wish</a> spell is used to cancel the effect of the feeblemind. A creature that can cast arcane spells, such as a sorcerer or a wizard, takes a -4 penalty on its saving throw."
        )->setCastingTime("1 standard action")->setComponents("a handful of clay, crystal, or glass spheres")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one creature")->setDuration("instantaneous")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Find the Path")->setLongDescription(
            "The recipient of this spell can find the shortest, most direct physical route to a prominent specified destination, such as a city, keep, lake, or dungeon. The locale can be outdoors or underground, as long as it is prominent. For example, a hunter's cabin is not prominent enough, but a logging camp is. Find the path works with respect to locations, not objects or creatures at a locale. The location must be on the same plane as the subject at the time of casting. The spell enables the subject to sense the correct direction that will eventually lead it to its destination, indicating at appropriate times the exact path to follow or physical actions to take. For example, the spell enables the subject to sense what cavern corridor to take when a choice presents itself. The spell ends when the destination is reached or the duration expires, whichever comes first. Find the path can be used to remove the subject and its companions from the effect of a <a href=\"Maze\">maze</a> spell in a single round, specifying the destination as outside the maze. This divination is keyed to the recipient, not its companions, and its effect does not predict or allow for the actions of creatures (including guardians) who might take action to oppose the caster as he follows the path revealed by this spell."
        )->setCastingTime("3 rounds")->setComponents("a set of divination counters")->setRange(
                "personal or touch"
            )->setTargets("you or creature touched")->setDuration("10 min./level")->setSavingThrow(
                "none or Will negates (harmless)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Find Traps")->setLongDescription(
            "You gain intuitive insight into the workings of traps. You gain an insight bonus equal to 1/2 your caster level (maximum +10) on Perception checks made to find traps while the spell is in effect. You receive a check to notice traps within 10 feet of you, even if you are not actively searching for them. Note that find traps grants no ability to disable the traps that you may find."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Finger of Death")->setLongDescription(
            "This spell instantly delivers 10 points of damage per caster level. If the target's Fortitude saving throw succeeds, it instead takes 3d6 points of damage + 1 point per caster level. The subject might die from damage even if it succeeds on its saving throw."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature")->setDuration("instantaneous")->setSavingThrow(
                "Fortitude partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fireball")->setLongDescription(
            "A fireball spell generates a searing explosion of flame that detonates with a low roar and deals 1d6 points of fire damage per caster level (maximum 10d6) to every creature within the area. Unattended objects also take this damage. The explosion creates almost no pressure. You point your finger and determine the range (distance and height) at which the fireball is to burst. A glowing, pea-sized bead streaks from the pointing digit and, unless it impacts upon a material body or solid barrier prior to attaining the prescribed range, blossoms into the fireball at that point. An early impact results in an early detonation. If you attempt to send the bead through a narrow passage, such as through an arrow slit, you must hit the opening with a ranged touch attack, or else the bead strikes the barrier and detonates prematurely. The fireball sets fire to combustibles and damages objects in the area. It can melt metals with low melting points, such as lead, gold, copper, silver, and bronze. If the damage caused to an interposing barrier shatters or breaks through it, the fireball may continue beyond the barrier if the area permits; otherwise it stops at the barrier just as any other spell effect does."
        )->setCastingTime("1 standard action")->setComponents("a ball of bat guano and sulfur")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fire Seeds")->setLongDescription(
            "Depending on the version of fire seeds you choose, you turn acorns into splash weapons that you or another character can throw, or you turn holly berries into bombs that you can detonate on command. Acorn Grenades: As many as four acorns turn into special thrown splash weapons. An acorn grenade has a range increment of 20 feet. A ranged touch attack roll is required to strike the intended target. Together, the acorns are capable of dealing 1d4 points of fire damage per caster level (maximum 20d4) divided among the acorns as you wish. No acorn can deal more than 10d4 points of damage. Each acorn grenade explodes upon striking any hard surface. In addition to its regular fire damage, all creatures adjacent to the explosion take 1 point of fire damage per die of the explosion. This explosion of fire ignites any combustible materials adjacent to the target. Holly Berry Bombs: You turn as many as eight holly berries into special bombs. The holly berries are usually placed by hand, since they are too light to make effective thrown weapons (they can be tossed only 5 feet). If you are within 200 feet and speak a word of command, each berry instantly bursts into flame, causing 1d8 points of fire damage + 1 point per caster level to every creature in a 5-foot-radius burst and igniting any combustible materials within 5 feet. A creature in the area that makes a successful Reflex saving throw takes only half damage."
        )->setCastingTime("1 standard action")->setComponents("acorns or holly berries")->setRange("touch")->setTargets(
                "up to four acorns or up to eight holly berries"
            )->setDuration("10 min./level or until used")->setSavingThrow("none or Reflex half")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fire Shield")->setLongDescription(
            "This spell wreathes you in flame and causes damage to each creature that attacks you in melee. The flames also protect you from either cold-based or fire-based attacks, depending on if you choose cool or warm flames for your fire shield. Any creature striking you with its body or a handheld weapon deals normal damage, but at the same time the attacker takes 1d6 points of damage + 1 point per caster level (maximum +15). This damage is either cold damage (if you choose a chill shield) or fire damage (if you choose a warm shield). If the attacker has spell resistance, it applies to this effect. Creatures wielding melee weapons with reach are not subject to this damage if they attack you. When casting this spell, you appear to immolate yourself, but the flames are thin and wispy, increasing the light level within 10 feet by one step, up to normal light. The color of the flames is blue or green if the chill shield is cast, violet or red if the warm shield is employed. The special powers of each version are as follows. Chill Shield: The flames are cool to the touch. You take only half damage from fire-based attacks. If such an attack allows a Reflex save for half damage, you take no damage on a successful saving throw. Warm Shield: The flames are warm to the touch. You take only half damage from cold-based attacks. If such an attack allows a Reflex save for half damage, you take no damage on a successful saving throw."
        )->setCastingTime("1 standard action")->setComponents(
                "phosphorus for the warm shield; a firefly or glowworm for the chill shield"
            )->setRange("personal")->setTargets("you")->setDuration("1 round/level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fire Storm")->setLongDescription(
            "When a fire storm spell is cast, the whole area is shot through with sheets of roaring flame. The raging flames do not harm natural vegetation, ground cover, or any plant creatures in the area that you wish to exclude from damage. Any other creature within the area takes 1d6 points of fire damage per caster level (maximum 20d6). Creatures that fail their Reflex save catch on fire, taking 4d6 points of fire damage each round until the flames are extinguished. Extinguishing the flames is a full-round action that requires a DC 20 Reflex save."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fire Trap")->setLongDescription(
            "Fire trap creates a fiery explosion when an intruder opens the item that the trap protects. A fire trap spell can ward any object that can be opened and closed. When casting fire trap, you select a point on the object as the spell's center. When someone other than you opens the object, a fiery explosion fills the area within a 5-foot radius around the spell's center. The flames deal 1d4 points of fire damage + 1 point per caster level (maximum +20). The item protected by the trap is not harmed by this explosion. A fire-trapped item cannot have a second closure or warding spell placed on it. A <a href=\"Knock\">knock</a> spell does not bypass a fire trap. An unsuccessful <a href=\"Dispel Magic\">dispel magic</a> spell does not detonate the spell. Underwater, this ward deals half damage and creates a large cloud of steam. You can use the fire-trapped object without discharging it, as can any individual to whom the object was specifically attuned when cast. Attuning a fire-trapped object to an individual usually involves setting a password that you can share with friends. Magic traps such as fire trap are hard to detect and disable. A rogue (only) can use the Perception skill to find a fire trap and Disable Device to thwart it. The DC in each case is 25 + spell level (DC 27 for a druid's fire trap or DC 29 for the arcane version)."
        )->setCastingTime("10 minutes")->setComponents("gold dust worth 25 gp")->setRange("touch")->setTargets(
                "object touched"
            )->setDuration("permanent until discharged (D)")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Flame Arrow")->setLongDescription(
            "This spell allows you to turn ammunition (such as arrows, crossbow bolts, shuriken, and sling stones) into fiery projectiles. Each piece of ammunition deals an extra 1d6 points of fire damage to any target it hits. A flaming projectile can easily ignite a flammable object or structure, but it won't ignite a creature it strikes."
        )->setCastingTime("1 standard action")->setComponents("a drop of oil and a small piece of flint")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("fifty projectiles, all of which must be together at the time of casting")->setDuration(
                "10 min./level"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Flame Blade")->setLongDescription(
            "A 3-foot-long, blazing beam of red-hot fire springs forth from your hand. You wield this blade-like beam as if it were a scimitar. Attacks with the flame blade are melee touch attacks. The blade deals 1d8 points of fire damage + 1 point per two caster levels (maximum +10). Since the blade is immaterial, your Strength modifier does not apply to the damage. A flame blade can ignite combustible materials such as parchment, straw, dry sticks, and cloth."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("0 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Flame Strike")->setLongDescription(
            "A flame strike evokes a vertical column of divine fire. The spell deals 1d6 points of damage per caster level (maximum 15d6). Half the damage is fire damage, but the other half results directly from <a href=\"Divine Power\">divine power</a> and is therefore not subject to being reduced by resistance to fire-based attacks."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Flaming Sphere")->setLongDescription(
            "A burning globe of fire rolls in whichever direction you point and burns those it strikes. It moves 30 feet per round. As part of this movement, it can ascend or jump up to 30 feet to strike a target. If it enters a space with a creature, it stops moving for the round and deals 3d6 points of fire damage to that creature, though a successful Reflex save negates that damage. A flaming sphere rolls over barriers less than 4 feet tall. It ignites flammable substances it touches and illuminates the same area as a torch would. The sphere moves as long as you actively direct it (a move action for you); otherwise, it merely stays at rest and burns. It can be extinguished by any means that would put out a normal fire of its size. The surface of the sphere has a spongy, yielding consistency and so does not cause damage except by its flame. It cannot push aside unwilling creatures or batter down large obstacles. A flaming sphere winks out if it exceeds the spell's range."
        )->setCastingTime("1 standard action")->setComponents("tallow, brimstone, and powdered iron")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("Reflex negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Flare")->setLongDescription(
            "This cantrip creates a burst of light. If you cause the light to burst in front of a single creature, that creature is dazzled for 1 minute unless it makes a successful Fortitude save. Sightless creatures, as well as creatures already dazzled, are not affected by flare."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Flesh to Stone")->setLongDescription(
            "The subject, along with all its carried gear, turns into a mindless, inert statue. If the statue resulting from this spell is broken or damaged, the subject (if ever returned to its original state) has similar damage or deformities. The creature is not dead, but it does not seem to be alive either when viewed with spells such as <a href=\"Deathwatch\">deathwatch</a>. Only creatures made of flesh are affected by this spell."
        )->setCastingTime("1 standard action")->setComponents("lime, water, and earth")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one creature")->setDuration("instantaneous")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Floating Disk")->setLongDescription(
            "You create a slightly concave, circular plane of force that follows you about and carries loads for you. The disk is 3 feet in diameter and 1 inch deep at its center. It can hold 100 pounds of weight per caster level. If used to transport a liquid, its capacity is 2 gallons. The disk floats approximately 3 feet above the ground at all times and remains level. It floats along horizontally within spell range and will accompany you at a rate of no more than your normal speed each round. If not otherwise directed, it maintains a constant interval of 5 feet between itself and you. The disk winks out of existence when the spell duration expires. The disk also winks out if you move beyond its range or try to take the disk more than 3 feet away from the surface beneath it. When the disk winks out, whatever it was supporting falls to the surface beneath it."
        )->setCastingTime("1 standard action")->setComponents("a drop of mercury")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 hour/level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fly")->setLongDescription(
            "The subject can fly at a speed of 60 feet (or 40 feet if it wears medium or heavy armor, or if it carries a medium or heavy load). It can ascend at half speed and descend at double speed, and its maneuverability is good. Using a fly spell requires only as much concentration as walking, so the subject can attack or cast spells normally. The subject of a fly spell can charge but not run, and it cannot carry aloft more weight than its maximum load, plus any armor it wears. The subject gains a bonus on Fly skill checks equal to 1/2 your caster level. Should the spell duration expire while the subject is still aloft, the magic fails slowly. The subject floats downward 60 feet per round for 1d6 rounds. If it reaches the ground in that amount of time, it lands safely. If not, it falls the rest of the distance, taking 1d6 points of damage per 10 feet of fall. Since dispelling a spell effectively ends it, the subject also descends safely in this way if the fly spell is dispelled, but not if it is negated by an <a href=\"Antimagic Field\">antimagic field</a>."
        )->setCastingTime("1 standard action")->setComponents("a wing feather")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fog Cloud")->setLongDescription(
            "A bank of fog billows out from the point you designate. The fog obscures all sight, including darkvision, beyond 5 feet. A creature within 5 feet has concealment (attacks have a 20% miss chance). Creatures farther away have total concealment (50% miss chance, and the attacker can't use sight to locate the target). A moderate wind (11+ mph) disperses the fog in 4 rounds; a strong wind (21+ mph) disperses the fog in 1 round. The spell does not function underwater."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft. level)"
            )->setTargets("")->setDuration("10 min./level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Forbiddance")->setLongDescription(
            "Forbiddance seals an area against all planar travel into or within it. This includes all teleportation spells (such as <a href=\"Dimension Door\">dimension door</a> and <a href=\"Teleport\">teleport</a>), plane shifting, astral travel, ethereal travel, and all summoning spells. Such effects simply fail automatically. In addition, it damages entering creatures whose alignments are different from yours. The effect on those attempting to enter the warded area is based on their alignment relative to yours (see below). A creature inside the area when the spell is cast takes no damage unless it exits the area and attempts to reenter, at which time it is affected as normal. Alignments identical: No effect. The creature may enter the area freely (although not by planar travel). Alignments different with respect to either law/chaos or good/evil: The creature takes 6d6 points of damage. A successful Will save halves the damage, and spell resistance applies. Alignments different with respect to both law/chaos and good/evil: The creature takes 12d6 points of damage. A successful Will save halves the damage, and spell resistance applies. At your option, the abjuration can include a password, in which case creatures of alignments different from yours can avoid the damage by speaking the password as they enter the area. You must select this option (and the password) at the time of casting. Adding a password requires the burning of additional rare incenses worth at least 1,000 gp, plus 1,000 gp per 60-foot cube. Dispel magic does not dispel a forbiddance effect unless the dispeller's level is at least as high as your caster level. You can't have multiple overlapping forbiddance effects. In such a case, the more recent effect stops at the boundary of the older effect."
        )->setCastingTime("6 rounds")->setComponents(
                "holy water and incense worth 1,500 gp, plus 1,500 gp per 60-foot cube"
            )->setRange("medium (100 ft. + 10 ft./level)")->setTargets("")->setDuration("permanent")->setSavingThrow(
                "see text"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Forcecage")->setLongDescription(
            "This spell creates an immobile, invisible cubical prison composed of either bars of force or solid walls of force (your choice). Creatures within the area are caught and contained unless they are too big to fit inside, in which case the spell automatically fails. Teleportation and other forms of astral travel provide a means of escape, but the force walls or bars extend into the Ethereal Plane, blocking ethereal travel. Like a <a href=\"Wall of Force\">wall of force</a>, a forcecage resists <a href=\"Dispel Magic\">dispel magic</a>, although a <a href=\"Mage's Disjunction\">mage's disjunction</a> still functions. The walls of a forcecage can be damaged by spells as normal, except for <a href=\"Disintegrate\">disintegrate</a>, which automatically destroys it. The walls of a forcecage can be damaged by weapons and supernatural abilities, but they have a Hardness of 30 and a number of hit points equal to 20 per caster level. Contact with a sphere of annihilation or rod of cancellation instantly destroys a forcecage. Barred Cage: This version of the spell produces a 20-foot cube made of bands of force (similar to a <a href=\"Wall of Force\">wall of force</a> spell) for bars. The bands are a half-inch wide, with half-inch gaps between them. Any creature capable of passing through such a small space can escape; others are confined within the barred cage. You can't attack a creature in a barred cage with a weapon unless the weapon can fit between the gaps. Even against such weapons (including arrows and similar ranged attacks), a creature in the barred cage has cover. All spells and breath weapons can pass through the gaps in the bars. Windowless Cell: This version of the spell produces a 10-foot cube with no way in and no way out. Solid walls of force form its six sides."
        )->setCastingTime("1 standard action")->setComponents("ruby dust worth 500 gp")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("Reflex negates")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Forceful Hand")->setLongDescription(
            "This spell functions as <a href=\"Interposing Hand\">interposing hand</a>, except that it can also pursue and bull rush one opponent you select. The forceful hand gets one bull rush attack per round. This attack does not provoke an attack of opportunity. Its CMB for bull rush checks uses your caster level in place of its base attack bonus, with a +8 bonus for its Strength score (27), and a +1 bonus for being Large. The hand always moves with the opponent to push them back as far as possible. It has no movement limit for this purpose. Directing the spell to a new target is a move action. Forceful hand prevents the opponent from moving closer to you without first succeeding on a bull rush attack, moving both the forceful hand and the target closer to you. The forceful hand can instead be directed to interpose itself, as <a href=\"Interposing Hand\">interposing hand</a> does."
        )->setCastingTime("1 standard action")->setComponents("a soft glove")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Foresight")->setLongDescription(
            "This spell grants you a powerful sixth sense in relation to yourself or another. Once foresight is cast, you receive instantaneous warnings of impending danger or harm to the subject of the spell. You are never surprised or flat-footed. In addition, the spell gives you a general idea of what action you might take to best protect yourself and gives you a +2 insight bonus to AC and on Reflex saves. This insight bonus is lost whenever you would lose a Dexterity bonus to AC. When another creature is the subject of the spell, you receive warnings about that creature. You must communicate what you learn to the other creature for the warning to be useful, and the creature can be caught unprepared in the absence of such a warning. Shouting a warning, yanking a person back, and even telepathically communicating (via an appropriate spell) can all be accomplished before some danger befalls the subject, provided you act on the warning without delay. The subject, however, does not gain the insight bonus to AC and Reflex saves."
        )->setCastingTime("1 standard action")->setComponents("a hummingbird's feather")->setRange(
                "personal or touch"
            )->setTargets("see text")->setDuration("10 min./level")->setSavingThrow(
                "none or Will negates (harmless)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Form of the Dragon 1")->setLongDescription(
            "You become a Medium chromatic or metallic dragon. You gain a +4 size bonus to Strength, a +2 size bonus to Constitution, a +4 natural armor bonus, fly 60 feet (poor), darkvision 60 feet, a breath weapon, and resistance to one element. You also gain one bite (1d8), two claws (1d6), and two wing attacks (1d4). Your breath weapon and resistance depend on the type of dragon. You can only use the breath weapon once per casting of this spell. All breath weapons deal 6d8 points of damage and allow a Reflex save for half damage. In addition, some of the dragon types grant additional abilities, as noted below. Black dragon: 60-foot line of acid, resist acid 20, swim 60 feet Blue dragon: 60-foot line of electricity, resist electricity 20, burrow 20 feet Green dragon: 30-foot cone of acid, resist acid 20, swim 40 feet Red dragon: 30-foot cone of fire, resist fire 30, vulnerability to cold White dragon: 30-foot <a href=\"Cone of Cold\">cone of cold</a>, resist cold 20, swim 60 feet, vulnerability to fire Brass dragon: 60-foot line of fire, resist fire 20, burrow 30 feet, vulnerability to cold Bronze dragon: 60-foot line of electricity, resist electricity 20, swim 60 feet Copper dragon: 60-foot line of acid, resist acid 20, <a href=\"Spider Climb\">spider climb</a> (always active) Gold dragon: 30-foot cone of fire, resist fire 20, swim 60 feet Silver dragon: 30-foot <a href=\"Cone of Cold\">cone of cold</a>, resist cold 30, vulnerability to fire"
        )->setCastingTime("1 standard action")->setComponents(
                "a scale of the dragon type you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                "see below"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Form of the Dragon 2")->setLongDescription(
            "This spell functions as <a href=\"Form of the Dragon I\">form of the dragon I</a> except that it also allows you to assume the form of a Large chromatic or metallic dragon. You gain the following abilities: a +6 size bonus to Strength, a +4 size bonus to Constitution, a +6 natural armor bonus, fly 90 feet (poor), darkvision 60 feet, a breath weapon, DR 5/magic, and resistance to one element. You also gain one bite (2d6), two claws (1d8), two wing attacks (1d6), and one tail slap attack (1d8). You can only use the breath weapon twice per casting of this spell, and you must wait 1d4 rounds between uses. All breath weapons deal 8d8 points of damage and allow a Reflex save for half damage. Line breath weapons increase to 80-foot lines and cones increase to 40-foot cones."
        )->setCastingTime("1 standard action")->setComponents(
                "a scale of the dragon type you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                "see below"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Form of the Dragon 3")->setLongDescription(
            "This spell functions as <a href=\"Form of the Dragon II\">form of the dragon II</a> save that it also allows you to take the form of a Huge chromatic or metallic dragon. You gain the following abilities: a +10 size bonus to Strength, a +8 size bonus to Constitution, a +8 natural armor bonus, fly 120 feet (poor), blindsense 60 feet, darkvision 120 feet, a breath weapon, DR 10/magic, frightful presence (DC equal to the DC for this spell), and immunity to one element (of the same type <a href=\"Form of the Dragon I\">form of the dragon I</a> grants resistance to). You also gain one bite (2d8), two claws (2d6), two wing attacks (1d8), and one tail slap attack (2d6). You can use the breath weapon as often as you like, but you must wait 1d4 rounds between uses. All breath weapons deal 12d8 points of damage and allow a Reflex save for half damage. Line breath weapons increase to 100-foot lines and cones increase to 50-foot cones."
        )->setCastingTime("1 standard action")->setComponents(
                "a scale of the dragon type you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                "see below"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fox's Cunning")->setLongDescription(
            "The target becomes smarter. The spell grants a +4 enhancement bonus to Intelligence, adding the usual benefits to Intelligence-based skill checks and other uses of the Intelligence modifier. Wizards (and other spellcasters who rely on Intelligence) affected by this spell do not gain any additional bonus spells for the increased Intelligence, but the save DCs for spells they cast while under this spell's effect do increase. This spell doesn't grant extra skill ranks."
        )->setCastingTime("1 standard action")->setComponents("hairs or dung from a fox")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Fox's Cunning, Mass")->setLongDescription(
            "This spell functions like <a href=\"Fox's Cunning\">fox's cunning</a>, except that it affects multiple creatures."
        )->setCastingTime("1 standard action")->setComponents("hairs or dung from a fox")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Freedom")->setLongDescription(
            "The subject is freed from spells and effects that restrict movement, including binding, entangle, grappling, imprisonment, maze, paralysis, petrification, pinning, sleep, slow, stunning, temporal stasis, and web. To free a creature from imprisonment or maze, you must know its name and background, and you must cast this spell at the spot where it was entombed or banished into the maze."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels) or see text"
            )->setTargets("one creature")->setDuration("instantaneous")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Freedom of Movement")->setLongDescription(
            "This spell enables you or a creature you touch to move and attack normally for the duration of the spell, even under the influence of magic that usually impedes movement, such as paralysis, solid fog, slow, and web. All combat maneuver checks made to grapple the target automatically fail. The subject automatically succeeds on any combat maneuver checks and Escape Artist checks made to escape a grapple or a pin. The spell also allows the subject to move and attack normally while underwater, even with slashing weapons such as axes and swords or with bludgeoning weapons such as flails, hammers, and maces, provided that the weapon is wielded in the hand rather than hurled. The freedom of movement spell does not, however, grant <a href=\"Water Breathing\">water breathing</a>."
        )->setCastingTime("1 standard action")->setComponents("a leather strip bound to the target")->setRange(
                "personal or touch"
            )->setTargets("you or creature touched")->setDuration("10 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Freezing Sphere")->setLongDescription(
            "Freezing sphere creates a frigid globe of cold energy that streaks from your fingertips to the location you select, where it explodes in a 40-foot-radius burst, dealing 1d6 points of cold damage per caster level (maximum 15d6) to each creature in the area. A creature of the water subtype instead takes 1d8 points of cold damage per caster level (maximum 15d8) and is staggered for 1d4 rounds. If the freezing sphere strikes a body of water or a liquid that is principally water (not including water-based creatures), it freezes the liquid to a depth of 6 inches in a 40-foot radius. This ice lasts for 1 round per caster level. Creatures that were swimming on the surface of a targeted body of water become trapped in the ice. Attempting to break free is a full-round action. A trapped creature must make a DC 25 Strength check or a DC 25 Escape Artist check to do so. You can refrain from firing the globe after completing the spell, if you wish. Treat this as a touch spell for which you are holding the charge. You can hold the charge for as long as 1 round per level, at the end of which time the freezing sphere bursts centered on you (and you receive no saving throw to resist its effect). Firing the globe in a later round is a standard action."
        )->setCastingTime("1 standard action")->setComponents("a small crystal sphere")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("see text")->setDuration("instantaneous or 1 round/level; see text")->setSavingThrow(
                "Reflex half"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Gaseous Form")->setLongDescription(
            "The subject and all its gear become insubstantial, misty, and translucent. Its material armor (including natural armor) becomes worthless, though its size, Dexterity, deflection bonuses, and armor bonuses from force effects still apply. The subject gains DR 10/magic and becomes immune to poison, sneak attacks, and critical hits. It can't attack or cast spells with verbal, somatic, material, or focus components while in gaseous form. This does not rule out the use of certain spells that the subject may have prepared using the feats Silent Spell, Still Spell, and Eschew Materials. The subject also loses supernatural abilities while in gaseous form. If it has a touch spell ready to use, that spell is discharged harmlessly when the gaseous form spell takes effect. A gaseous creature can't run, but it can fly at a speed of 10 feet and automatically succeeds on all Fly skill checks. It can pass through small holes or narrow openings, even mere cracks, with all it was wearing or holding in its hands, as long as the spell persists. The creature is subject to the effects of wind, and it can't enter water or other liquid. It also can't manipulate objects or activate items, even those carried along with its gaseous form. Continuously active items remain active, though in some cases their effects may be moot."
        )->setCastingTime("1 standard action")->setComponents("a bit of gauze and a wisp of smoke")->setRange(
                "touch"
            )->setTargets("willing corporeal creature touched")->setDuration("2 min./level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Gate")->setLongDescription(
            "Casting a gate spell has two effects. First, it creates an interdimensional connection between your plane of existence and a plane you specify, allowing travel between those two planes in either direction. Second, you may then call a particular individual or kind of being through the gate. The gate itself is a circular hoop or disk from 5 to 20 feet in diameter (caster's choice) oriented in the direction you desire when it comes into existence (typically vertical and facing you). It is a two-dimensional window looking into the plane you specified when casting the spell, and anyone or anything that moves through is shunted instantly to the other side. A gate has a front and a back. Creatures moving through the gate from the front are transported to the other plane; creatures moving through it from the back are not. Planar Travel: As a mode of planar travel, a gate spell functions much like a <a href=\"Plane Shift\">plane shift</a> spell, except that the gate opens precisely at the point you desire (a creation effect). Deities and other beings who rule a planar realm can prevent a gate from opening in their presence or personal demesnes if they so desire. Travelers need not join hands with you--anyone who chooses to step through the portal is transported. A gate cannot be opened to another point on the same plane; the spell works only for interplanar travel. You may hold the gate open only for a brief time (no more than 1 round per caster level), and you must concentrate on doing so, or else the interplanar connection is severed. Calling Creatures: The second effect of the gate spell is to call an extraplanar creature to your aid (a calling effect). By naming a particular being or kind of being as you cast the spell, you cause the gate to open in the immediate vicinity of the desired creature and pull the subject through, willing or unwilling. Deities and unique beings are under no compulsion to come through the gate, although they may choose to do so of their own accord. This use of the spell creates a gate that remains open just long enough to transport the called creatures. This use of the spell has a material cost of 10,000 gp in rare incense and offerings. This cost is in addition to any cost that must be paid to the called creatures. If you choose to call a kind of creature instead of a known individual, you may call either a single creature or several creatures. In either case, their total HD cannot exceed twice your caster level. In the case of a single creature, you can control it if its HD does not exceed your caster level. A creature with more HD than your caster level can't be controlled. Deities and unique beings cannot be controlled in any event. An uncontrolled being acts as it pleases, making the calling of such creatures rather dangerous. An uncontrolled being may return to its home plane at any time. If you choose to exact a longer or more involved form of service from a called creature, you must offer some fair trade in return for that service. The service exacted must be reasonable with respect to the promised favor or reward; see the <a href=\"Planar Ally, Lesser\">lesser planar ally</a> spell for appropriate rewards. Some creatures may want their payment in livestock rather than in coin, which could involve complications. Immediately upon completion of the service, the being is transported to your vicinity, and you must then and there turn over the promised reward. After this is done, the creature is instantly freed to return to its own plane. Failure to fulfill the promise to the letter results in your being subjected to service by the creature or by its liege and master, at the very least. At worst, the creature or its kin may attack you. Note: When you use a calling spell such as gate to call an air, chaotic, earth, evil, fire, good, lawful, or water creature, it becomes a spell of that type."
        )->setCastingTime("1 standard action")->setComponents("see text")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration(
                "instantaneous or concentration (up to 1 round/level); see text"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Geas, Lesser")->setLongDescription(
            "A lesser geas places a magical command on a creature to carry out some service or to refrain from some action or course of activity, as desired by you. The creature must have 7 or fewer HD and be able to understand you. While a geas cannot compel a creature to kill itself or perform acts that would result in certain death, it can cause almost any other course of activity. The geased creature must follow the given instructions until the geas is completed, no matter how long it takes. If the instructions involve some open-ended task that the recipient cannot complete through his own actions, the spell remains in effect for a maximum of 1 day per caster level. A clever recipient can subvert some instructions. If the subject is prevented from obeying the lesser geas for 24 hours, it takes a -2 penalty to each of its ability scores. Each day, another -2 penalty accumulates, up to a total of -8. No ability score can be reduced to less than 1 by this effect. The ability score penalties are removed 24 hours after the subject resumes obeying the lesser geas. A lesser geas (and all ability score penalties) can be ended by <a href=\"Break Enchantment\">break enchantment</a>, <a href=\"Limited Wish\">limited wish</a>, <a href=\"Remove Curse\">remove curse</a>, <a href=\"Miracle\">miracle</a>, or <a href=\"Wish\">wish</a>. <a href=\"Dispel Magic\">Dispel magic</a> does not affect a lesser geas."
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                "one living creature with 7 HD or less"
            )->setDuration("1 day/level or until discharged (D)")->setSavingThrow("Will negates")->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Geas/Quest")->setLongDescription(
            "This spell functions similarly to lesser geas, except that it affects a creature of any HD and allows no saving throw. If the subject is prevented from obeying the geas/quest for 24 hours, it takes a -3 penalty to each of its ability scores. Each day, another -3 penalty accumulates, up to a total of -12. No ability score can be reduced to less than 1 by this effect. The ability score penalties are removed 24 hours after the subject resumes obeying the geas/quest. A <a href=\"Remove Curse\">remove curse</a> spell ends a geas/quest spell only if its caster level is at least two higher than your caster level. <a href=\"Break Enchantment\">Break enchantment</a> does not end a geas/quest, but <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, and <a href=\"Wish\">wish</a> do. Bards, sorcerers, and wizards usually refer to this spell as geas, while clerics call the same spell quest."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("")->setTargets(
                "one living creature"
            )->setDuration("1 day/level or until discharged (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Gentle Repose")->setLongDescription(
            "You preserve the remains of a dead creature so that they do not decay. Doing so effectively extends the time limit on raising that creature from the dead (see raise dead). Days spent under the influence of this spell don't count against the time limit. Additionally, this spell makes transporting a slain (and thus decaying) comrade less unpleasant. The spell also works on severed body parts and the like."
        )->setCastingTime("1 standard action")->setComponents(
                "salt and a copper piece for each of the corpse's eyes"
            )->setRange("touch")->setTargets("corpse touched")->setDuration("1 day/level")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ghost Sound")->setLongDescription(
            "Ghost sound allows you to create a volume of sound that rises, recedes, approaches, or remains at a fixed place. You choose what type of sound ghost sound creates when casting it and cannot thereafter change the sound's basic character. The volume of sound created depends on your level. You can produce as much noise as four normal humans per caster level (maximum 40 humans). Thus, talking, singing, shouting, walking, marching, or running sounds can be created. The noise a ghost sound spell produces can be virtually any type of sound within the volume limit. A horde of rats running and squeaking is about the same volume as eight humans running and shouting. A roaring lion is equal to the noise from 16 humans, while a roaring dragon is equal to the noise from 32 humans. Anyone who hears a ghost sound receives a Will save to disbelieve. Ghost sound can enhance the effectiveness of a <a href=\"Silent Image\">silent image</a> spell. Ghost sound can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("a bit of wool or a small lump of wax")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("Will disbelief")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ghoul touch")->setLongDescription(
            "Imbuing you with negative energy, this spell allows you to paralyze a single living humanoid for the duration of the spell with a successful melee touch attack. A paralyzed subject exudes a carrion stench that causes all living creatures (except you) in a 10-foot-radius spread to become sickened (Fortitude negates). A <a href=\"Neutralize Poison\">neutralize poison</a> spell removes the effect from a sickened creature, and creatures immune to poison are unaffected by the stench."
        )->setCastingTime("1 standard action")->setComponents(
                "cloth from a ghoul or earth from a ghoul's lair"
            )->setRange("touch")->setTargets("living humanoid touched")->setDuration("1d6+2 rounds")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Giant Form 1")->setLongDescription(
            "When you cast this spell you can assume the form of any Large humanoid creature of the giant subtype. Once you assume your new form, you gain the following abilities: a +6 size bonus to Strength, a -2 penalty to Dexterity, a +4 size bonus to Constitution, a +4 natural armor bonus, and low-light vision. If the form you assume has any of the following abilities, you gain the listed ability: darkvision 60 feet, rend (2d6 damage), regeneration 5, rock catching, and rock throwing (range 60 feet, 2d6 damage). If the creature has immunity or resistance to any elements, you gain resistance 20 to those elements. If the creature has vulnerability to an element, you gain that vulnerability."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Giant Form 2")->setLongDescription(
            "This spell functions as <a href=\"Giant Form I\">giant form I</a> except that it also allows you to assume the form of any Huge creature of the giant type. You gain the following abilities: a +8 size bonus to Strength, a -2 penalty to Dexterity, a +6 size bonus to Constitution, a +6 natural armor bonus, low-light vision, and a +10 foot enhancement bonus to your speed. If the form you assume has any of the following abilities, you gain the listed ability: swim 60 feet, darkvision 60 feet, rend (2d8 damage), regeneration 5, rock catching, and rock throwing (range 120 feet, 2d10 damage). If the creature has immunity or resistance to one element, you gain that immunity or resistance. If the creature has vulnerability to an element, you gain that vulnerability."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Giant Vermin")->setLongDescription(
            "You turn a number of normal-sized centipedes, scorpions, or spiders into their giant counterparts. Only one type of vermin can be transmuted (so a single casting cannot affect both a centipede and a spider). The number of vermin which can be affected by this spell depends on your caster level, as noted on the table below. Giant vermin created by this spell do not attempt to harm you, but your control of such creatures is limited to simple commands (Attack, Defend, Stop, and so forth). Orders to attack a certain creature when it appears or guard against a particular occurrence are too complex for the vermin to understand. Unless commanded to do otherwise, the giant vermin attack whomever or whatever is near them. <table><tr><th>Caster Level</th><th>Centipedes</th><th>Scorpions</th><th>Spiders</th></tr><tr><td>9th or lower</td><td>3</td><td>1</td><td>2</td></tr><tr class=\"alt\"><td>10th-13th</td><td>4</td><td>2</td><td>3</td></tr><tr><td>14th-17th</td><td>6</td><td>3</td><td>4</td></tr><tr class=\"alt\"><td>18th-19th</td><td>8</td><td>4</td><td>5</td></tr><tr><td>20th or higher</td><td>12</td><td>6</td><td>8</td></tr></table>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("1 or more vermin, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Glibness")->setLongDescription(
            "Your speech becomes fluent and more believable, causing those who hear you to believe every word you say. You gain a +20 bonus on Bluff checks made to convince another of the truth of your words. This bonus doesn't apply to other uses of the Bluff skill, such as feinting in combat, creating a diversion to hide, or communicating a hidden message via innuendo. If a magical effect is used against you that would detect your lies or force you to speak the truth, the user of the effect must succeed on a caster level check (1d20 + caster level) against a DC of 15 + your caster level to succeed. Failure means the effect does not detect your lies or force you to speak only the truth."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "10 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Glitterdust")->setLongDescription(
            "A cloud of golden particles covers everyone and everything in the area, causing creatures to become blinded and visibly outlining invisible things for the duration of the spell. All within the area are covered by the dust, which cannot be removed and continues to sparkle until it fades. Each round at the end of their turn blinded creatures may attempt new saving throws to end the blindness effect. Any creature covered by the dust takes a -40 penalty on Stealth checks."
        )->setCastingTime("1 standard action")->setComponents("ground mica")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow(
                "Will negates (blinding only)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Globe of Invulnerability")->setLongDescription(
            "This spell functions like lesser globe of invulnerability, except that it also excludes 4th-level spells and spell-like effects."
        )->setCastingTime("1 standard action")->setComponents("a glass or crystal bead")->setRange(
                "10 ft."
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Globe of Invulnerability, Lesser")->setLongDescription(
            "An immobile, faintly shimmering magical sphere surrounds you and excludes all spell effects of 3rd level or lower. The area or effect of any such spells does not include the area of the lesser globe of invulnerability. Such spells fail to affect any target located within the globe. Excluded effects include spell-like abilities and spells or spell-like effects from items. Any type of spell, however, can be cast through or out of the magical globe. Spells of 4th level and higher are not affected by the globe, nor are spells already in effect when the globe is cast. The globe can be brought down by a <a href=\"Dispel Magic\">dispel magic</a> spell. You can leave and return to the globe without penalty. Note that spell effects are not disrupted unless their effects enter the globe, and even then they are merely suppressed, not dispelled.  If a given spell has more than one level depending on which character class is casting it, use the level appropriate to the caster to determine whether lesser globe of invulnerability stops it."
        )->setCastingTime("1 standard action")->setComponents("a glass or crystal bead")->setRange(
                "10 ft."
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Glyph of Warding")->setLongDescription(
            "This powerful inscription harms those who enter, pass, or open the warded area or object. A glyph of warding can guard a bridge or passage, ward a portal, trap a chest or box, and so on. You set all of the conditions of the ward. Typically, any creature entering the warded area or opening the warded object without speaking a password (which you set when casting the spell) is subject to the magic it stores. Alternatively or in addition to a password trigger, glyphs can be set according to physical characteristics (such as height or weight) or creature type, subtype, or kind. Glyphs can also be set with respect to good, evil, law, or chaos, or to pass those of your religion. They cannot be set according to class, HD, or level. Glyphs respond to invisible creatures normally but are not triggered by those who travel past them ethereally. Multiple glyphs cannot be cast on the same area. However, if a cabinet has three different drawers, each can be separately warded. When casting the spell, you weave a tracery of faintly glowing lines around the warding sigil. A glyph can be placed to conform to any shape up to the limitations of your total square footage. When the spell is completed, the glyph and tracery become nearly invisible. Glyphs cannot be affected or bypassed by such means as physical or magical probing, though they can be dispelled. <a href=\"Mislead\">Mislead</a>, <a href=\"Polymorph\">polymorph</a>, and <a href=\"Nondetection\">nondetection</a> (and similar magical effects) can fool a glyph, though nonmagical disguises and the like can't. <a href=\"Read Magic\">Read magic</a> allows you to identify a glyph of warding with a DC 13 Knowledge (arcana) check. Identifying the glyph does not discharge it and allows you to know the basic nature of the glyph (version, type of damage caused, what spell is stored). Note: Magic traps such as glyph of warding are hard to detect and disable. A rogue (only) can use the Perception skill to find the glyph and Disable Device to thwart it. The DC in each case is 25 + spell level, or 28 for glyph of warding. Depending on the version selected, a glyph either blasts the intruder or activates a spell. Blast Glyph: A blast glyph deals 1d8 points of damage per two caster levels (maximum 5d8) to the intruder and to all within 5 feet of him or her. This damage is acid, cold, fire, electricity, or sonic (caster's choice, made at time of casting). Each creature affected can attempt a Reflex save to take half damage. Spell resistance applies against this effect. Spell Glyph: You can store any harmful spell of 3rd level or lower that you know. All level-dependent features of the spell are based on your caster level at the time of casting the glyph. If the spell has a target, it targets the intruder. If the spell has an area or an amorphous effect, the area or effect is centered on the intruder. If the spell summons creatures, they appear as close as possible to the intruder and attack. Saving throws and spell resistance operate as normal, except that the DC is based on the level of the spell stored in the glyph."
        )->setCastingTime("10 minutes")->setComponents("powdered diamond worth 200 gp")->setRange("touch")->setTargets(
                "object touched"
            )->setDuration("permanent until discharged (D)")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Glyph of Warding, Greater")->setLongDescription(
            "This spell functions like <a href=\"Glyph of Warding\">glyph of warding</a>, except that a greater blast glyph deals up to 10d8 points of damage, and a greater spell glyph can store a spell of 6th level or lower. <a href=\"Read Magic\">Read magic</a> allows you to identify a greater glyph of warding with a DC 16 Spellcraft check. Material Component: You trace the glyph with incense, which must first be sprinkled with powdered diamond worth at least 400 gp."
        )->setCastingTime("10 minutes")->setComponents("powdered diamond worth 200 gp")->setRange("touch")->setTargets(
                "object touched"
            )->setDuration("permanent until discharged (D)")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Goodberry")->setLongDescription(
            "Casting goodberry makes 2d4 freshly picked berries magical. You (as well as any other druid of 3rd or higher level) can immediately discern which berries are affected. Each transmuted berry provides nourishment as if it were a normal meal for a Medium creature. The berry also cures 1 point of damage when eaten, subject to a maximum of 8 points of such curing in any 24-hour period."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "2d4 fresh berries touched"
            )->setDuration("1 day/level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Good Hope")->setLongDescription(
            "This spell instills powerful hope in the subjects. Each affected creature gains a +2 morale bonus on saving throws, attack rolls, ability checks, skill checks, and weapon damage rolls. Good hope counters and dispels <a href=\"Crushing Despair\">crushing despair</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one living creature/level, no two of which may be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Grasping Hand")->setLongDescription(
            "This spell functions as <a href=\"Interposing Hand\">interposing hand</a>, except that it can also grapple one opponent you select. The grasping hand gets one grapple attack per round. This attack does not provoke an attack of opportunity. Its CMB and CMD for grapple checks use your caster level in place of its base attack bonus, with a +10 bonus for its Strength (31) score and a +1 bonus for being Large (its Dexterity is 10, granting no bonus on the Combat Maneuver Defense). The hand holds but does not harm creatures that it grapples. Directing the spell to a new target is a move action. The grasping hand can instead be directed to bull rush a target, using the same bonuses outlined above, or it can be directed to interpose itself, as <a href=\"Interposing Hand\">interposing hand</a> does."
        )->setCastingTime("1 standard action")->setComponents("a soft glove")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Grease")->setLongDescription(
            "A grease spell covers a solid surface with a layer of slippery grease. Any creature in the area when the spell is cast must make a successful Reflex save or fall. A creature can walk within or through the area of grease at half normal speed with a DC 10 Acrobatics check. Failure means it can't move that round (and must then make a Reflex save or fall), while failure by 5 or more means it falls (see the Acrobatics skill for details). Creatures that do not move on their turn do not need to make this check and are not considered flat-footed. The spell can also be used to create a greasy coating on an item. Material objects not in use are always affected by this spell, while an object wielded or employed by a creature requires its bearer to make a Reflex saving throw to avoid the effect. If the initial saving throw fails, the creature immediately drops the item. A saving throw must be made in each round that the creature attempts to pick up or use the greased item. A creature wearing greased armor or clothing gains a +10 circumstance bonus on Escape Artist checks and combat maneuver checks made to escape a grapple, and to their CMD to avoid being grappled."
        )->setCastingTime("1 standard action")->setComponents("butter")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one object or 10-ft. square")->setDuration("1 min./level (D)")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Guards and Wards")->setLongDescription(
            "This powerful spell is primarily used to defend a stronghold or fortress by creating a number of magical wards and effects. The ward protects 200 square feet per caster level. The warded area can be as much as 20 feet high, and shaped as you desire. You can ward several stories of a stronghold by dividing the area among them; you must be somewhere within the area to be warded to cast the spell. The spell creates the following magical effects within the warded area. Fog: Fog fills all corridors, obscuring all sight, including darkvision, beyond 5 feet. A creature within 5 feet has concealment (attacks have a 20% miss chance). Creatures farther away have total concealment (50% miss chance, and the attacker cannot use sight to locate the target). Saving Throw: none. Spell Resistance: no. Arcane Locks: All doors in the warded area are arcane locked. Saving Throw: none. Spell Resistance: no. Webs: Webs fill all stairs from top to bottom. These strands are identical with those created by the <a href=\"Web\">web</a> spell, except that they regrow in 10 minutes if they are burned or torn away while the guards and wards spell lasts. Saving Throw: Reflex negates; see text for <a href=\"Web\">web</a>. Spell Resistance: no. Confusion: Where there are choices in direction--such as a corridor intersection or side passage--a minor confusion-type effect functions so as to make it 50% probable that intruders believe they are going in the opposite direction from the one they actually chose. This is a mind-affecting effect. Saving Throw: none. Spell Resistance: yes. Lost Doors: One door per caster level is covered by a <a href=\"Silent Image\">silent image</a> to appear as if it were a plain wall. Saving Throw: Will disbelief (if interacted with). Spell Resistance: no. In addition, you can place your choice of one of the following five magical effects. 1. <a href=\"Dancing Lights\">Dancing lights</a> in four corridors. You can designate a simple program that causes the lights to repeat as long as the guards and wards spell lasts. Saving Throw: none. Spell Resistance: no. 2. A <a href=\"Magic Mouth\">magic mouth</a> in two places. Saving Throw: none. Spell Resistance: no. 3. A <a href=\"Stinking Cloud\">stinking cloud</a> in two places. The vapors appear in the places you designate; they return within 10 minutes if dispersed by wind while the guards and wards spell lasts. Saving Throw: Fortitude negates; see text for <a href=\"Stinking Cloud\">stinking cloud</a>. Spell Resistance: no. 4. A <a href=\"Gust of Wind\">gust of wind</a> in one corridor or room. Saving Throw: Fortitude negates. Spell Resistance: yes. 5. A <a href=\"Suggestion\">suggestion</a> in one place. You select an area of up to 5 feet square, and any creature who enters or passes through the area receives the suggestion mentally. Saving Throw: Will negates. Spell Resistance: yes. The whole warded area radiates strong magic of the abjuration school. A <a href=\"Dispel Magic\">dispel magic</a> cast on a specific effect, if successful, removes only that effect. A successful <a href=\"Mage's Disjunction\">mage's disjunction</a> destroys the entire guards and wards effect."
        )->setCastingTime("30 minutes")->setComponents(
                "burning incense, a small measure of brimstone and oil, a knotted string, and a small amount of blood & a small silver rod"
            )->setRange("anywhere within the area to be warded")->setTargets("")->setDuration(
                "2 hours/level (D)"
            )->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Guidance")->setLongDescription(
            "This spell imbues the subject with a touch of divine guidance. The creature gets a +1 competence bonus on a single attack roll, saving throw, or skill check. It must choose to use the bonus before making the roll to which it applies."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 minute or until discharged")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Gust of Wind")->setLongDescription(
            "This spell creates a severe blast of air (approximately 50 mph) that originates from you, affecting all creatures in its path. All flying creatures in this area take a -4 penalty on Fly skill checks. Tiny or smaller flying creatures must make a DC 25 Fly skill check or be blown back 2d6 x 10 feet and take 2d6 points of damage. Small or smaller flying creatures must make a DC 20 Fly skill check to move against the force of the wind. A Tiny or smaller creature on the ground is knocked down and rolled 1d4 x 10 feet, taking 1d4 points of nonlethal damage per 10 feet. Small creatures are knocked prone by the force of the wind. Medium or smaller creatures are unable to move forward against the force of the wind unless they succeed at a DC 15 Strength check. Large or larger creatures may move normally within a gust of wind effect. This spell can't move a creature beyond the limit of it's range. Any creature, regardless of size, takes a -4 penalty on ranged attacks and Perception checks in the area of a gust of wind. The force of the gust automatically extinguishes candles, torches, and similar unprotected flames. It causes protected flames, such as those in lanterns, to dance wildly and has a 50% chance to extinguish those lights. In addition to the effects noted, a gust of wind can do anything that a sudden blast of wind would be expected to do. It can create a stinging spray of sand or dust, fan a large fire, overturn delicate awnings or hangings, heel over a small boat, and blow gases or vapors to the edge of its range. Gust of wind can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "1 round"
            )->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hallow")->setLongDescription(
            "Hallow makes a particular site, building, or structure a holy site. This has four major effects. First, the site is warded by a <a href=\"Magic Circle against Evil\">magic circle against evil</a> effect. Second, the DC to resist positive channeled energy within this area gains a +4 sacred bonus and the DC to resist negative energy is reduced by 4. Spell resistance does not apply to this effect. This provision does not apply to the druid version of the spell. Third, any dead body interred in a hallowed site cannot be turned into an undead creature. Finally, you can fix a single spell effect to the hallowed site. The spell effect lasts for 1 year and functions throughout the entire site, regardless of the normal duration and area or effect. You may designate whether the effect applies to all creatures, creatures who share your faith or alignment, or creatures who adhere to another faith or alignment. At the end of the year, the chosen effect lapses, but it can be renewed or replaced simply by casting hallow again. Spell effects that may be tied to a hallowed site include aid, <a href=\"Bane\">bane</a>, <a href=\"Bless\">bless</a>, <a href=\"Cause Fear\">cause fear</a>, <a href=\"Darkness\">darkness</a>, <a href=\"Daylight\">daylight</a>, <a href=\"Death Ward\">death ward</a>, <a href=\"Deeper Darkness\">deeper darkness</a>, <a href=\"Detect Evil\">detect evil</a>, <a href=\"Detect Magic\">detect magic</a>, <a href=\"Dimensional Anchor\">dimensional anchor</a>, <a href=\"Discern Lies\">discern lies</a>, <a href=\"Dispel Magic\">dispel magic</a>, <a href=\"Endure Elements\">endure elements</a>, <a href=\"Freedom of Movement\">freedom of movement</a>, <a href=\"Invisibility Purge\">invisibility purge</a>, <a href=\"Protection from Energy\">protection from energy</a>, <a href=\"Remove Fear\">remove fear</a>, <a href=\"Resist Energy\">resist energy</a>, <a href=\"Silence\">silence</a>, <a href=\"Tongues\">tongues</a>, and <a href=\"Zone of Truth\">zone of truth</a>. Saving throws and spell resistance might apply to these spells' effects. (See the individual spell descriptions for details.) An area can receive only one hallow spell (and its associated spell effect) at a time. Hallow counters but does not dispel <a href=\"Unhallow\">unhallow</a>."
        )->setCastingTime("24 hours")->setComponents(
                "herbs, oils, and incense worth at least 1,000 gp, plus 1,000 gp per level of the spell to be included in the hallowed area"
            )->setRange("touch")->setTargets("")->setDuration("instantaneous")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hallucinatory Terrain")->setLongDescription(
            "You make natural terrain look, sound, and smell like some other sort of natural terrain. Structures, equipment, and creatures within the area are not hidden or changed in appearance."
        )->setCastingTime("10 minutes")->setComponents("a stone, a twig, and a green leaf")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("2 hours/level (D)")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Halt Undead")->setLongDescription(
            "This spell renders as many as three undead creatures immobile. A nonintelligent undead creature gets no saving throw; an intelligent undead creature does. If the spell is successful, it renders the undead creature immobile for the duration of the spell (similar to the effect of <a href=\"Hold Person\">hold person</a> on a living creature). The effect is broken if the halted creatures are attacked or take damage."
        )->setCastingTime("1 standard action")->setComponents("a pinch of sulfur and powdered garlic")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("up to three undead creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "1 round/level"
            )->setSavingThrow("Will negates (see text)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Harm")->setLongDescription(
            "Harm charges a subject with negative energy that deals 10 points of damage per caster level (to a maximum of 150 points at 15th level). If the creature successfully saves, harm deals half this amount. Harm cannot reduce the target's hit points to less than 1. If used on an undead creature, harm acts like <a href=\"Heal\">heal</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heal")->setLongDescription(
            "Heal enables you to channel positive energy into a creature to wipe away injury and afflictions. It immediately ends any and all of the following adverse conditions affecting the target: ability damage, blinded, confused, dazed, dazzled, deafened, diseased, exhausted, fatigued, feebleminded, insanity, nauseated, poisoned, sickened, and stunned. It also cures 10 hit points of damage per level of the caster, to a maximum of 150 points at 15th level. Heal does not remove negative levels or restore permanently drained ability score points. If used against an undead creature, heal instead acts like harm."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heal, Mass")->setLongDescription(
            "This spell functions like <a href=\"Heal\">heal</a>, except as noted above. The maximum number of hit points restored to each creature is 250."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one or more creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heal Mount")->setLongDescription(
            "This spell functions like <a href=\"Heal\">heal</a>, but it affects only the paladin's special mount (typically a horse)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "your mount touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heat Metal")->setLongDescription(
            "Heat metal causes metal objects to become red-hot. Unattended, nonmagical metal gets no saving throw. Magical metal is allowed a saving throw against the spell. An item in a creature's possession uses the creature's saving throw bonus unless its own is higher. A creature takes fire damage if its equipment is heated. It takes full damage if its armor, shield, or weapon is affected. The creature takes minimum damage (1 point or 2 points; see the table) if it's not wearing or wielding such an item. On the first round of the spell, the metal becomes warm and uncomfortable to touch but deals no damage. The same effect also occurs on the last round of the spell's duration. During the second (and also the next-to-last) round, intense heat causes pain and damage. In the third, fourth, and fifth rounds, the metal is searing hot, and causes more damage, as shown on the table below. <table><tr><th>Round</th><th>Metal Temperature</th><th>Damage</th></tr><tr><td>1</td><td>Warm</td><td>None</td></tr><tr class=\"alt\"><td>2</td><td>Hot</td><td>1d4 points</td></tr><tr><td>3-5</td><td>Searing</td><td>2d4 points</td></tr><tr class=\"alt\"><td>6</td><td>Hot</td><td>1d4 points</td></tr><tr><td>7</td><td>Warm</td><td>None</td></tr></table>Any cold intense enough to damage the creature negates fire damage from the spell (and vice versa) on a point-for-point basis. If cast underwater, heat metal deals half damage and boils the surrounding water. Heat metal counters and dispels <a href=\"Chill Metal\">chill metal</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "metal equipment of one creature per two levels, no two of which can be more than 30 ft. apart; or 25 lbs. of metal/level, all of which must be within a 30-ft. circle"
            )->setDuration("7 rounds")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Helping Hand")->setLongDescription(
            "You create the ghostly image of a hand, which you can send to find a creature within 5 miles. The hand then beckons to that creature and leads it to you if the creature is willing to follow. When the spell is cast, you specify a person (or any creature) by physical description, which can include race, gender, and appearance but not ambiguous factors such as level, alignment, or class. When the description is done, the hand streaks off in search of a subject that fits the description. The amount of time it takes to find the subject depends on how far away he is, as detailed on the following table. <table><tr><th>Distance</th><th>Time to Locate</th></tr><tr><td>100 ft. or less</td><td>1 round</td></tr><tr class=\"alt\"><td>1,000 ft.</td><td>1 minute</td></tr><tr><td>1 mile</td><td>10 minutes</td></tr><tr class=\"alt\"><td>2 miles</td><td>1 hour</td></tr><tr><td>3 miles</td><td>2 hours</td></tr><tr class=\"alt\"><td>4 miles</td><td>3 hours</td></tr><tr><td>5 miles</td><td>4 hours</td></tr></table>Once the hand locates the subject, it beckons the creature to follow it. If the subject does so, the hand points in your direction, indicating the most direct, feasible route. The hand hovers 10 feet in front of the subject, moving before it at a speed of as much as 240 feet per round. Once the hand leads the subject back to you, it disappears. The subject is not compelled to follow the hand or act in any particular way toward you. If the subject chooses not to follow, the hand continues to beckon for the duration of the spell, then disappears. If the spell expires while the subject is en route to you, the hand disappears; the subject must then rely on its own devices to locate you. If more than one subject in a 5-mile radius meets the description, the hand locates the closest creature. If that creature refuses to follow the hand, the hand does not seek out a second subject. If, at the end of 4 hours of searching, the hand has found no subject that matches the description within 5 miles, it returns to you, displays an outstretched palm (indicating that no such creature was found), and disappears. The ghostly hand has no physical form. It is invisible to anyone except you and a potential subject. It cannot engage in combat or execute any other task aside from locating a subject and leading it back to you. The hand can't pass through solid objects but can ooze through small cracks and slits. The hand cannot travel more than 5 miles from the spot it appeared when you cast the spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("5 miles")->setTargets("")->setDuration(
                "1 hour/level"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heroes' Feast")->setLongDescription(
            "You bring forth a great feast, including a magnificent table, chairs, service, and food and drink. The feast takes 1 hour to consume, and the beneficial effects do not set in until this hour is over. Every creature partaking of the feast is cured of all sickness and nausea, receives the benefits of both <a href=\"Neutralize Poison\">neutralize poison</a> and <a href=\"Remove Disease\">remove disease</a>, and gains 1d8 temporary hit points + 1 point per two caster levels (maximum +10) after imbibing the nectar-like beverage that is part of the feast. The ambrosial food grants each creature that partakes a +1 morale bonus on attack rolls and Will saves and a +4 morale bonus on saving throws against poison and fear effects for 12 hours. If the feast is interrupted for any reason, the spell is ruined and all effects of the spell are negated."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 hour plus 12 hours; see text")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heroism")->setLongDescription(
            "This spell imbues a single creature with great bravery and morale in battle. The target gains a +2 morale bonus on attack rolls, saves, and skill checks."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("10 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Heroism, Greater")->setLongDescription(
            "This spell functions like <a href=\"Heroism\">heroism</a>, except the creature gains a +4 morale bonus on attack rolls, saves, and skill checks, immunity to fear effects, and temporary hit points equal to your caster level (maximum 20)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hide from Animals")->setLongDescription(
            "Animals cannot sense the warded creatures. Even extraordinary or supernatural sensory capabilities, such as blindsense, blindsight, scent, and tremorsense, cannot detect or locate warded creatures. Animals simply act as though the warded creatures are not there. If a warded character touches an animal or attacks any creature, even with a spell, the spell ends for all recipients."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one creature touched/level"
            )->setDuration("10 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hide from Undead")->setLongDescription(
            "Undead cannot see, hear, or smell creatures warded by this spell. Even extraordinary or supernatural sensory capabilities, such as blindsense, blindsight, scent, and tremorsense, cannot detect or locate warded creatures. Nonintelligent undead creatures (such as skeletons or zombies) are automatically affected and act as though the warded creatures are not there. An intelligent undead creature gets a single Will saving throw. If it fails, the subject can't see any of the warded creatures. If it has reason to believe unseen opponents are present, however, it can attempt to find or strike them. If a warded creature attempts to channel positive energy, turn or command undead, touches an undead creature, or attacks any creature (even with a spell), the spell ends for all recipients."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched creature/level"
            )->setDuration("10 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hideous Laughter")->setLongDescription(
            "This spell afflicts the subject with uncontrollable laughter. It collapses into gales of manic laughter, falling prone. The subject can take no actions while laughing, but is not considered helpless. After the spell ends, it can act normally. On the creature's next turn, it may attempt a new saving throw to end the effect. This is a full round action that does not provoke attacks of opportunity. If this save is successful, the effect ends. If not, the creature continues laughing for the entire duration. A creature with an Intelligence score of 2 or lower is not affected. A creature whose type is different from the caster's receives a +4 bonus on its saving throw, because humor doesn't translate well."
        )->setCastingTime("1 standard action")->setComponents("tiny fruit tarts and a feather")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature; see text")->setDuration("1 round/level")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hold Animal")->setLongDescription(
            "This spell functions like <a href=\"Hold Person\">hold person</a>, except that it affects an animal instead of a humanoid."
        )->setCastingTime("")->setComponents("")->setRange("")->setTargets("one animal")->setDuration(
                ""
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hold Monster")->setLongDescription(
            "This spell functions like <a href=\"Hold Person\">hold person</a>, except that it affects any living creature that fails its Will save."
        )->setCastingTime("")->setComponents(
                "one hard metal bar or rod, which can be as small as a three-penny nail"
            )->setRange("")->setTargets("one living creature")->setDuration("")->setSavingThrow("")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hold Monster, Mass")->setLongDescription(
            "This spell functions like <a href=\"Hold Person\">hold person</a>, except that it affects multiple creatures and holds any living creature that fails its Will save."
        )->setCastingTime("")->setComponents(
                "one hard metal bar or rod, which can be as small as a three-penny nail"
            )->setRange("")->setTargets(
                "one or more creatures, no two of which can be more than 30 ft. apart"
            )->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hold Person")->setLongDescription(
            "The subject becomes paralyzed and freezes in place. It is aware and breathes normally but cannot take any actions, even speech. Each round on its turn, the subject may attempt a new saving throw to end the effect. This is a full-round action that does not provoke attacks of opportunity. A winged creature who is paralyzed cannot flap its wings and falls. A swimmer can't swim and may drown."
        )->setCastingTime("1 standard action")->setComponents("a small, straight piece of iron")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one humanoid creature")->setDuration("1 round/level (D); see text")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hold Person, Mass")->setLongDescription(
            "This spell functions like <a href=\"Hold Person\">hold person</a>, except as noted above."
        )->setCastingTime("1 standard action")->setComponents("a small, straight piece of iron")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one or more humanoid creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "1 round/level (D); see text"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hold Portal")->setLongDescription(
            "This spell magically holds shut a door, gate, window, or shutter of wood, metal, or stone. The magic affects the portal just as if it were securely closed and normally locked. A <a href=\"Knock\">knock</a> spell or a successful <a href=\"Dispel Magic\">dispel magic</a> spell can negate a hold portal spell. Add 5 to the normal DC for forcing open a portal affected by this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one portal, up to 20 sq. ft./level")->setDuration("1 min./level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Holy Aura")->setLongDescription(
            "A brilliant divine radiance surrounds the subjects, protecting them from attacks, granting them resistance to spells cast by evil creatures, and causing evil creatures to become blinded when they strike the subjects. This abjuration has four effects. First, each warded creature gains a +4 deflection bonus to AC and a +4 resistance bonus on saves. Unlike <a href=\"Protection from Evil\">protection from evil</a>, this benefit applies against all attacks, not just against attacks by evil creatures. Second, each warded creature gains spell resistance 25 against evil spells and spells cast by evil creatures. Third, the abjuration protects the recipient from possession and mental influence, just as <a href=\"Protection from Evil\">protection from evil</a> does. Finally, if an evil creature succeeds on a melee attack against a creature warded by a holy aura, the offending attacker is blinded (Fortitude save negates, as <a href=\"Blindness/Deafness\">blindness/deafness</a>, but against holy aura's save DC)."
        )->setCastingTime("1 standard action")->setComponents("a tiny reliquary worth 500 gp")->setRange(
                "20 ft."
            )->setTargets("one creature/level in a 20-ft.-radius burst centered on you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Holy Smite")->setLongDescription(
            "You draw down holy power to smite your enemies. Only evil and neutral creatures are harmed by the spell; good creatures are unaffected. The spell deals 1d8 points of damage per two caster levels (maximum 5d8) to each evil creature in the area (or 1d6 points of damage per caster level, maximum 10d6, to an evil outsider) and causes it to become blinded for 1 round. A successful Will saving throw reduces damage to half and negates the blinded effect. The spell deals only half damage to creatures who are neither good nor evil, and they are not blinded. Such a creature can reduce that damage by half (down to one-quarter of the roll) with a successful Will save."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous (1 round); see text")->setSavingThrow(
                "Will partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Holy Sword")->setLongDescription(
            "This spell allows you to channel holy power into your sword, or any other melee weapon you choose. The weapon acts as a +5 holy weapon (+5 enhancement bonus on attack and damage rolls, extra 2d6 damage against evil opponents). It also emits a <a href=\"Magic Circle against Evil\">magic circle against evil</a> effect (as the spell). If the magic circle ends, the sword creates a new one on your turn as a free action. The spell is automatically canceled 1 round after the weapon leaves your hand. You cannot have more than one holy sword at a time. If this spell is cast on a magic weapon, the powers of the spell supercede any that the weapon normally has, rendering the normal enhancement bonus and powers of the weapon inoperative for the duration of the spell. This spell is not cumulative with bless weapon or any other spell that might modify the weapon in any way. This spell does not work on artifacts. A masterwork weapon's bonus to attack does not stack with an enhancement bonus to attack."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "melee weapon touched"
            )->setDuration("1 round/level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Holy Word")->setLongDescription(
            "Any nongood creature within the area of a holy word spell suffers the following ill effects. <table><tr><th>HD</th><th>Effect</th></tr><tr class=\"alt\"><td>Equal to caster level</td><td>Deafened</td></tr><tr><td>Up to caster level -1</td><td>Blinded, deafened</td></tr><tr class=\"alt\"><td>Up to caster level -5</td><td>Paralyzed, blinded, deafened</td></tr><tr><td>Up to caster level -10</td><td>Killed, paralyzed, blinded, deafened</td></tr></table> The effects are cumulative and concurrent. A successful Will save reduces or eliminates these effects. Creatures affected by multiple effects make only one save and apply the result to all the effects. Deafened: The creature is deafened for 1d4 rounds. Save negates. Blinded: The creature is blinded for 2d4 rounds. Save reduces the blinded effect to 1d4 rounds. Paralyzed: The creature is paralyzed and helpless for 1d10 minutes. Save reduces the paralyzed effect to 1 round. Killed: Living creatures die. Undead creatures are destroyed. Save negates. If the save is successful, the creature instead takes 3d6 points of damage + 1 point per caster level (maximum +25). Furthermore, if you are on your home plane when you cast this spell, nongood extraplanar creatures within the area are instantly banished back to their home planes. Creatures so banished cannot return for at least 24 hours. This effect takes place regardless of whether the creatures hear the holy word or not. The banishment effect allows a Will save (at a -4 penalty) to negate. Creatures whose HD exceed your caster level are unaffected by holy word."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("40 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Horrid Wilting")->setLongDescription(
            "This spell evaporates moisture from the body of each subject living creature, causing flesh to wither and crack and crumble to dust. This deals 1d6 points of damage per caster level (maximum 20d6). This spell is especially devastating to water elementals and plant creatures, which instead take 1d8 points of damage per caster level (maximum 20d8)."
        )->setCastingTime("1 standard action")->setComponents("a bit of sponge")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("living creatures, no two of which can be more than 60 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Fortitude half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hypnotic Pattern")->setLongDescription(
            "A twisting pattern of subtle, shifting colors weaves through the air, fascinating creatures within it. Roll 2d4 and add your caster level (maximum 10) to determine the total number of HD of creatures affected. Creatures with the fewest HD are affected first; and, among creatures with equal HD, those who are closest to the spell's point of origin are affected first. HD that are not sufficient to affect a creature are wasted. Affected creatures become fascinated by the pattern of colors. Sightless creatures are not affected. A wizard or sorcerer need not utter a sound to cast this spell, but a bard must perform as a verbal component."
        )->setCastingTime("1 standard action")->setComponents(
                "bard only & a stick of incense or a crystal rod"
            )->setRange("medium (100 ft. + 10 ft./level)")->setTargets("")->setDuration(
                "Concentration + 2 rounds"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Hypnotism")->setLongDescription(
            "Your gestures and droning incantation fascinate nearby creatures, causing them to stop and stare blankly at you. In addition, you can use their rapt attention to make your suggestions and requests seem more plausible. Roll 2d4 to see how many total HD of creatures you affect. Creatures with fewer HD are affected before creatures with more HD. Only creatures that can see or hear you are affected, but they do not need to understand you to be fascinated. If you use this spell in combat, each target gains a +2 bonus on its saving throw. If the spell affects only a single creature not in combat at the time, the saving throw has a penalty of -2. While the subject is fascinated by this spell, it reacts as though it were two steps more friendly in attitude. This allows you to make a single request of the affected creature (provided you can communicate with it). The request must be brief and reasonable. Even after the spell ends, the creature retains its new attitude toward you, but only with respect to that particular request. A creature that fails its saving throw does not remember that you enspelled it."
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("2d4 rounds (D)")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ice Storm")->setLongDescription(
            "Great magical hailstones pound down upon casting this spell, dealing 3d6 points of bludgeoning damage and 2d6 points of cold damage to every creature in the area. This damage only occurs once, when the spell is cast. For the remaining duration of the spell, heavy snow and sleet rains down in the area. Creatures inside this area take a -4 penalty on Perception skill checks and the entire area is treated as difficult terrain. At the end of the duration, the snow and hail disappear, leaving no aftereffects (other than the damage dealt)."
        )->setCastingTime("1 standard action")->setComponents("dust and water")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Identify")->setLongDescription(
            "This spell functions as <a href=\"Detect Magic\">detect magic</a>, except that it gives you a +10 enhancement bonus on Spellcraft checks made to identify the properties and command words of magic items in your possession. This spell does not allow you to identify artifacts."
        )->setCastingTime("1 standard action")->setComponents("wine stirred with an owl's feather")->setRange(
                "60 ft."
            )->setTargets("")->setDuration("3 rounds/level (D)")->setSavingThrow(": none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Illusory Script")->setLongDescription(
            "You write instructions or other information on parchment, paper, or any suitable writing material. The illusory script appears to be some form of foreign or magical writing. Only the person (or people) designated by you at the time of the casting can read the writing; it's unintelligible to any other character. Any unauthorized creature attempting to read the script triggers a potent illusory effect and must make a saving throw. A successful saving throw means the creature can look away with only a mild sense of disorientation. Failure means the creature is subject to a suggestion implanted in the script by you at the time the illusory script spell was cast. The suggestion lasts only 30 minutes. Typical suggestions include Close the book and leave, Forget the existence of this note, and so forth. If successfully dispelled by <a href=\"Dispel Magic\">dispel magic</a>, the illusory script and its secret message disappear. The hidden message can be read by a combination of the <a href=\"True Seeing\">true seeing</a> spell with the <a href=\"Read Magic\">read magic</a> or <a href=\"Comprehend Languages\">comprehend languages</a> spell."
        )->setCastingTime("1 minute per page")->setComponents("lead-based ink worth 50 gp")->setRange(
                "touch"
            )->setTargets("one touched object weighing no more than 10 lbs.")->setDuration(
                "one day/level (D)"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Illusory Wall")->setLongDescription(
            "This spell creates the illusion of a wall, floor, ceiling, or similar surface. It appears absolutely real when viewed, but physical objects can pass through it without difficulty. When the spell is used to hide pits, traps, or normal doors, any detection abilities that do not require sight work normally. Touch or a probing search reveals the true nature of the surface, though such measures do not cause the illusion to disappear. Although the caster can see through his illusory wall, other creatures cannot, even if they succeed at their will save (but they do learn that it is not real)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("permanent")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Imbue with Spell Ability")->setLongDescription(
            "You transfer some of your currently prepared spells, and the ability to cast them, to another creature. Only a creature with an Intelligence score of at least 5 and a Wisdom score of at least 9 can receive this boon. Only cleric spells from the schools of abjuration, divination, and conjuration (healing) can be transferred. The number and level of spells that the subject can be granted depends on its Hit Dice; even multiple castings of imbue with spell ability can't exceed this limit. <table><tr><th>HD of Recipient</th><th>Spells Imbued</th></tr><tr><td>2 or lower</td><td>One 1st-level spell</td></tr><tr class=\"alt\"><td>3-4</td><td>One or two 1st-level spells</td></tr><tr><td>5 or higher</td><td>One or two 1st-level spells and  one 2nd-level spell</td></tr></table> The transferred spell's variable characteristics (range, duration, area, and the like) function according to your level, not the level of the recipient. Once you cast imbue with spell ability, you cannot prepare a new 4th-level spell to replace it until the recipient uses the imbued spells or is slain, or until you dismiss the imbue with spell ability spell. In the meantime, you remain responsible to your deity or your principles for the use to which the spell is put. If the number of 4th-level spells you can cast decreases, and that number drops below your current number of active imbue with spell ability spells, the more recently cast imbued spells are dispelled. To cast a spell with a verbal component, the subject must be able to speak. To cast a spell with a somatic component, it must be able to move freely. To cast a spell with a material component or focus, it must have the materials or focus."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("touch")->setTargets(
                "creature touched; see text"
            )->setDuration("permanent until discharged (D)")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Implosion")->setLongDescription(
            "This spell causes a destructive resonance in a corporeal creature's body. Each round you concentrate (including the first), you can cause one creature to collapse in on itself, inflicting 10 points of damage per caster level. If you break concentration, the spell immediately ends, though any implosions that have already happened remain in effect. You can target a particular creature only once with each casting of the spell. Implosion has no effect on creatures in gaseous form or on incorporeal creatures."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one corporeal creature/round")->setDuration(
                "concentration (up to 1 round per 2 levels)"
            )->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Imprisonment")->setLongDescription(
            "When you cast imprisonment and touch a creature, it is entombed in a state of suspended animation (see the <a href=\"Temporal Stasis\">temporal stasis</a> spell) in a small sphere far beneath the surface of the ground. The subject remains there unless a <a href=\"Freedom\">freedom</a> spell is cast at the locale where the imprisonment took place. Magical search by a crystal ball, a <a href=\"Locate Object\">locate object</a> spell, or some other similar <a href=\"Divination\">divination</a> does not reveal the fact that a creature is imprisoned, but <a href=\"Discern Location\">discern location</a> does. A <a href=\"Wish\">wish</a> or <a href=\"Miracle\">miracle</a> spell will not free the recipient, but will reveal where it is entombed. If you know the target's name and some facts about its life, the target takes a -4 penalty on its save."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Incendiary Cloud")->setLongDescription(
            "An incendiary cloud spell creates a cloud of roiling smoke shot through with white-hot embers. The smoke obscures all sight as a fog cloud does. In addition, the white-hot embers within the cloud deal 6d6 points of fire damage to everything within the cloud on your turn each round. All targets can make Reflex saves each round to take half damage. As with a <a href=\"Cloudkill\">cloudkill</a> spell, the smoke moves away from you at 10 feet per round. Figure out the smoke's new spread each round based on its new point of origin, which is 10 feet farther away from where you were when you cast the spell. By concentrating, you can make the cloud move as much as 60 feet each round. Any portion of the cloud that would extend beyond your maximum range dissipates harmlessly, reducing the remainder's spread thereafter. As with <a href=\"Fog Cloud\">fog cloud</a>, wind disperses the smoke, and the spell can't be cast underwater."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow(
                ": Reflex half, see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Critical Wounds")->setLongDescription(
            "This spell functions like <a href=\"Inflict Light Wounds\">inflict light wounds</a>, except that you deal 4d8 points of damage + 1 point per caster level (maximum +20)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Critical Wounds, Mass")->setLongDescription(
            "This spell functions like <a href=\"Inflict Light Wounds, Mass\">mass inflict light wounds</a>, except that it deals 4d8 points of damage + 1 point per caster level (maximum +40)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Light Wounds")->setLongDescription(
            "When laying your hand upon a creature, you channel negative energy that deals 1d8 points of damage + 1 point per caster level (maximum +5). Since undead are powered by negative energy, this spell cures such a creature of a like amount of damage, rather than harming it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Light Wounds, Mass")->setLongDescription(
            "Negative energy spreads out in all directions from the point of origin, dealing 1d8 points of damage + 1 point per caster level (maximum +25) to nearby living enemies. Like other inflict spells, mass inflict light wounds cures undead in its area rather than damaging them. A cleric capable of spontaneously casting inflict spells can also spontaneously cast mass inflict spells."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Moderate Wounds")->setLongDescription(
            "This spell functions like <a href=\"Inflict Light Wounds\">inflict light wounds</a>, except that you deal 2d8 points of damage + 1 point per caster level (maximum +10)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Moderate Wounds, Mass")->setLongDescription(
            "This spell functions like <a href=\"Inflict Light Wounds, Mass\">mass inflict light wounds</a>, except that it deals 2d8 points of damage + 1 point per caster level (maximum +30)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Serious Wounds")->setLongDescription(
            "This spell functions like <a href=\"Inflict Light Wounds\">inflict light wounds</a>, except that you deal 3d8 points of damage + 1 point per caster level (maximum +15)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Inflict Serious Wounds, Mass")->setLongDescription(
            "This spell functions like <a href=\"Inflict Light Wounds, Mass\">mass inflict light wounds</a>, except that it deals 3d8 points of damage + 1 point per caster level (maximum +35)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Insanity")->setLongDescription(
            "The affected creature suffers from a continuous confusion effect, as the spell. Remove curse does not remove insanity. <a href=\"Restoration, Greater\">Greater restoration</a>, <a href=\"Heal\">heal</a>, <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, or <a href=\"Wish\">wish</a> can restore the creature."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one living creature")->setDuration("instantaneous")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Insect Plague")->setLongDescription(
            "You summon a number of swarms of wasps (one per three levels, to a maximum of six swarms at 18th level). The swarms must be summoned so that each one is adjacent to at least one other swarm (that is, the swarms must fill one contiguous area). You may summon the wasp swarms so that they share the area of other creatures. Each swarm attacks any creatures occupying its area. The swarms are stationary after being summoned, and won't pursue creatures that flee."
        )->setCastingTime("1 round")->setComponents("")->setRange("long (400 ft. + 40 ft./level)")->setTargets(
                ""
            )->setDuration("1 min./level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Instant Summons")->setLongDescription(
            "You call some nonliving item directly to your hand from virtually any location. First, you must place your arcane mark on the item. Then you cast this spell, which magically and invisibly inscribes the name of the item on a sapphire worth at least 1,000 gp. Thereafter, you can summon the item by speaking a special word (set by you when the spell is cast) and crushing the gem. The item appears instantly in your hand. Only you can use the gem in this way. If the item is in the possession of another creature, the spell does not work, but you know who the possessor is and roughly where that creature is located when the summons occurs. The inscription on the gem is invisible. It is also unreadable, except by means of a <a href=\"Read Magic\">read magic</a> spell, to anyone but you. The item can be summoned from another plane, but only if no other creature has claimed ownership of it."
        )->setCastingTime("1 standard action")->setComponents("sapphire worth 1,000 gp")->setRange(
                "see text"
            )->setTargets("one object weighing 10 lbs. or less whose longest dimension is 6 ft. or less")->setDuration(
                "permanent until discharged"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Interposing Hand")->setLongDescription(
            "Interposing hand creates a Large magic hand that appears between you and one opponent. This floating, disembodied hand then moves to remain between the two of you, regardless of where you move or how the opponent tries to get around it, providing cover (+4 AC) for you against that opponent. Nothing can fool the hand--it sticks with the selected opponent in spite of darkness, invisibility, polymorphing, or any other attempt at hiding or disguise. The hand does not pursue an opponent, however. An interposing hand is 10 feet long and about that wide with its fingers outstretched. It has as many hit points as you do when you're undamaged, and is AC 20 (-1 size, +11 natural). It takes damage as a normal creature, but most magical effects that don't cause damage do not affect it. The hand never provokes attacks of opportunity from opponents. It cannot push through a <a href=\"Wall of Force\">wall of force</a> or enter an <a href=\"Antimagic Field\">antimagic field</a>, but it suffers the full effect of a <a href=\"Prismatic Wall\">prismatic wall</a> or <a href=\"Prismatic Sphere\">prismatic sphere</a>. The hand makes saving throws as its caster. <a href=\"Disintegrate\">Disintegrate</a> or a successful <a href=\"Dispel Magic\">dispel magic</a> destroys it. Any creature weighing 2,000 pounds or less that tries to push past the hand is slowed to half its normal speed. The hand cannot reduce the speed of a creature weighing more than 2,000 pounds, but it still affects the creature's attacks.  Directing the spell to a new target is a move action."
        )->setCastingTime("1 standard action")->setComponents("a soft glove")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Invisibility")->setLongDescription(
            "The creature or object touched becomes invisible. If the recipient is a creature carrying gear, that vanishes, too. If you cast the spell on someone else, neither you nor your allies can see the subject, unless you can normally see invisible things or you employ magic to do so. Items dropped or put down by an invisible creature become visible; items picked up disappear if tucked into the clothing or pouches worn by the creature. Light, however, never becomes invisible, although a source of light can become so (thus, the effect is that of a light with no visible source). Any part of an item that the subject carries but that extends more than 10 feet from it becomes visible. Of course, the subject is not magically silenced, and certain other conditions can render the recipient detectable (such as swimming in water or stepping in a puddle). If a check is required, a stationary invisible creature has a +40 bonus on its Stealth checks. This bonus is reduced to +20 if the creature is moving. The spell ends if the subject attacks any creature. For purposes of this spell, an attack includes any spell targeting a foe or whose area or effect includes a foe. Exactly who is a foe depends on the invisible character's perceptions. Actions directed at unattended objects do not break the spell. Causing harm indirectly is not an attack. Thus, an invisible being can open doors, talk, eat, climb stairs, summon monsters and have them attack, cut the ropes holding a rope bridge while enemies are on the bridge, remotely trigger traps, open a portcullis to release attack dogs, and so forth. If the subject attacks directly, however, it immediately becomes visible along with all its gear. Spells such as <a href=\"Bless\">bless</a> that specifically affect allies but not foes are not attacks for this purpose, even when they include foes in their area. Invisibility can be made permanent (on objects only) with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("an eyelash encased in gum arabic")->setRange(
                "personal or touch"
            )->setTargets("you or a creature or object weighing no more than 100 lbs./level")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("Will negates (harmless) or Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Invisibility, Greater")->setLongDescription(
            "This spell functions like <a href=\"Invisibility\">invisibility</a>, except that it doesn't end if the subject attacks."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal or touch")->setTargets(
                "you or creature touched"
            )->setDuration("1 round/level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Invisibility, Mass")->setLongDescription(
            "This spell functions like <a href=\"Invisibility\">invisibility</a>, except that the effect moves with the group and is broken when anyone in the group attacks. Individuals in the group cannot see each other. The spell is broken for any individual who moves more than 180 feet from the nearest member of the group. If only two individuals are affected, the one moving away from the other one loses its invisibility. If both are moving away from each other, they both become visible when the distance between them exceeds 180 feet."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("any number of creatures, no two of which can be more than 180 ft. apart")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Invisibility Purge")->setLongDescription(
            "You surround yourself with a sphere of power with a radius of 5 feet per caster level that negates all forms of invisibility. Anything invisible becomes visible while in the area."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Invisibility Sphere")->setLongDescription(
            "This spell functions like <a href=\"Invisibility\">invisibility</a>, except that this spell confers invisibility upon all creatures within 10 feet of the recipient at the time the spell is cast. The center of the effect is mobile with the recipient. Those affected by this spell can see each other and themselves as if unaffected by the spell. Any affected creature moving out of the area becomes visible, but creatures moving into the area after the spell is cast do not become invisible. Affected creatures (other than the recipient) who attack negate the invisibility only for themselves. If the spell recipient attacks, the invisibility sphere ends."
        )->setCastingTime("")->setComponents("")->setRange("")->setTargets("")->setDuration("")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Iron Body")->setLongDescription(
            "This spell transforms your body into living iron, which grants you several powerful resistances and abilities. You gain damage reduction 15/adamantine. You are immune to blindness, critical hits, ability score damage, deafness, disease, drowning, electricity, poison, stunning, and all spells or attacks that affect your physiology or respiration, because you have no physiology or respiration while this spell is in effect. You take only half damage from acid and fire. However, you also become vulnerable to all special attacks that affect iron golems. You gain a +6 enhancement bonus to your Strength score, but you take a -6 penalty to Dexterity as well (to a minimum Dexterity score of 1), and your speed is reduced to half normal. You have an arcane spell failure chance of 35% and a -6 armor check penalty, just as if you were clad in full plate armor. You cannot drink (and thus can't use potions) or play wind instruments. Your unarmed attack deals damage equal to a club sized for you (1d4 for Small characters or 1d6 for Medium characters), and you are considered armed when making unarmed attacks. Your weight increases by a factor of 10, causing you to sink in water like a stone. However, you could survive the lack of air at the bottom of the ocean--at least until the spell duration expires."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of iron from an iron golem, a hero's armor, or a war machine"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ironwood")->setLongDescription(
            "Ironwood is a magical substance created by druids from normal wood. While remaining natural wood in almost every way, ironwood is as strong, heavy, and resistant to fire as steel. Spells that affect metal or iron do not function on ironwood. Spells that affect wood do affect ironwood, although ironwood does not burn. Using this spell with wood shape or a wood-related Craft check, you can fashion wooden items that function as steel items. Thus, wooden plate armor and wooden swords can be created that are as durable as their normal steel counterparts. These items are freely usable by druids. Further, if you make only half as much ironwood as the spell would normally allow, any weapon, shield, or suit of armor so created is treated as a magic item with a +1 enhancement bonus."
        )->setCastingTime("1 minute/lb. created")->setComponents("wood to be transformed")->setRange(
                "0 ft."
            )->setTargets("")->setDuration("1 day/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Irresistible Dance")->setLongDescription(
            "The subject feels an undeniable urge to dance and begins doing so, complete with foot shuffling and tapping. The spell effect makes it impossible for the subject to do anything other than caper and prance in place. The effect imposes a -4 penalty to Armor Class and a -10 penalty on Reflex saves, and it negates any AC bonus granted by a shield the target holds. The dancing subject provokes attacks of opportunity each round on its turn. A successful Will save reduces the duration of this effect to 1 round."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("1d4+1 rounds")->setSavingThrow("Will partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Jump")->setLongDescription(
            "The subject gets a +10 enhancement bonus on Acrobatics checks made to attempt high jumps or long jumps. The enhancement bonus increases to +20 at caster level 5th, and to +30 (the maximum) at caster level 9th."
        )->setCastingTime("1 standard action")->setComponents("a grasshopper's hind leg")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level (D)")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Keen Edge")->setLongDescription(
            "This spell makes a weapon magically keen, improving its ability to deal telling blows. This transmutation doubles the threat range of the weapon. A threat range of 20 becomes 19-20, a threat range of 19-20 becomes 17-20, and a threat range of 18-20 becomes 15-20. The spell can be cast only on piercing or slashing weapons. If cast on arrows or crossbow bolts, the keen edge on a particular projectile ends after one use, whether or not the missile strikes its intended target. Treat shuriken as arrows, rather than as thrown weapons, for the purpose of this spell. Multiple effects that increase a weapon's threat range (such as the keen special weapon property and the Improved Critical feat) don't stack. You can't cast this spell on a natural weapon, such as a claw."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "one weapon or 50 projectiles, all of which must be together at the time of casting"
            )->setDuration("10 min./level")->setSavingThrow("Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Knock")->setLongDescription(
            "Knock opens stuck, barred, or locked doors, as well as those subject to <a href=\"Hold Portal\">hold portal</a> or <a href=\"Arcane Lock\">arcane lock</a>. When you complete the casting of this spell, make a caster level check against the DC of the lock with a +10 bonus. If successful, knock opens up to two means of closure. This spell opens secret doors, as well as locked or trick-opening boxes or chests. It also loosens welds, shackles, or chains (provided they serve to hold something shut). If used to open an arcane locked door, the spell does not remove the <a href=\"Arcane Lock\">arcane lock</a> but simply suspends its functioning for 10 minutes. In all other cases, the door does not relock itself or become stuck again on its own. Knock does not raise barred gates or similar impediments (such as a portcullis), nor does it affect ropes, vines, and the like. The effect is limited by the area. Each casting can undo as many as two means of preventing access. "
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one door, box, or chest with an area of up to 10 sq. ft./level")->setDuration(
                "instantaneous; see text"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Know Direction")->setLongDescription(
            "When you cast this spell, you instantly know the direction of north from your current position. The spell is effective in any environment in which north exists, but it may not work in extraplanar settings. Your knowledge of north is correct at the moment of casting, but you can get lost again within moments if you don't find some external reference point to help you keep track of direction."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "instantaneous"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Legend Lore")->setLongDescription(
            "Legend lore brings to your mind legends about an important person, place, or thing. If the person or thing is at hand, or if you are in the place in question, the casting time is only 1d4 x 10 minutes. If you have only detailed information on the person, place, or thing, the casting time is 1d10 days, and the resulting lore is less complete and specific (though it often provides enough information to help you find the person, place, or thing, thus allowing a better legend lore result next time). If you know only rumors, the casting time is 2d6 weeks, and the resulting lore is vague and incomplete (though it often directs you to more detailed information, thus allowing a better legend lore result next time). During the casting, you cannot engage in other than routine activities: eating, sleeping, and so forth. When completed, the divination brings legends (if any) about the person, place, or things to your mind. These may be legends that are still current, legends that have been forgotten, or even information that has never been generally known. If the person, place, or thing is not of legendary importance, you gain no information. As a rule of thumb, characters who are 11th level and higher are legendary, as are the sorts of creatures they contend with, the major magic items they wield, and the places where they perform their key deeds."
        )->setCastingTime("see text")->setComponents(
                "incense worth 250 gp & four pieces of ivory worth 50 gp each"
            )->setRange("personal")->setTargets("you")->setDuration("see text")->setSavingThrow("")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Levitate")->setLongDescription(
            "Levitate allows you to move yourself, another creature, or an object up and down as you wish. A creature must be willing to be levitated, and an object must be unattended or possessed by a willing creature. You can mentally direct the recipient to move up or down as much as 20 feet each round; doing so is a move action. You cannot move the recipient horizontally, but the recipient could clamber along the face of a cliff, for example, or push against a ceiling to move laterally (generally at half its base land speed). A levitating creature that attacks with a melee or ranged weapon finds itself increasingly unstable; the first attack has a -1 penalty on attack rolls, the second -2, and so on, to a maximum penalty of -5. A full round spent stabilizing allows the creature to begin again at -1."
        )->setCastingTime("1 standard action")->setComponents(
                "a leather loop or golden wire bent into a cup shape"
            )->setRange("personal or close (25 ft. + 5 ft./2 levels)")->setTargets(
                "you or one willing creature or one object (total weight up to 100 lbs./level)"
            )->setDuration("1 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Light")->setLongDescription(
            "This spell causes a touched object to glow like a torch, shedding normal light in a 20-foot radius, and increasing the light level for an additional 20 feet by one step, up to normal light (darkness becomes dim light, and dim light becomes normal light). In an area of normal or bright light, this spell has no effect. The effect is immobile, but it can be cast on a movable object. You can only have one light spell active at any one time. If you cast this spell while another casting is still in effect, the previous casting is dispelled. If you make this spell permanent (through <a href=\"Permanency\">permanency</a> or a similar effect), it does not count against this limit. Light can be used to counter or dispel any <a href=\"Darkness\">darkness</a> spell of equal or lower spell level."
        )->setCastingTime("1 standard action")->setComponents("a firefly")->setRange("touch")->setTargets(
                "object touched"
            )->setDuration("10 min./level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Lightning Bolt")->setLongDescription(
            "You release a powerful stroke of electrical energy that deals 1d6 points of electricity damage per caster level (maximum 10d6) to each creature within its area. The bolt begins at your fingertips. The lightning bolt sets fire to combustibles and damages objects in its path. It can melt metals with a low melting point, such as lead, gold, copper, silver, or bronze. If the damage caused to an interposing barrier shatters or breaks through it, the bolt may continue beyond the barrier if the spell's range permits; otherwise, it stops at the barrier just as any other spell effect does."
        )->setCastingTime("1 standard action")->setComponents("fur and a glass rod")->setRange("120 ft.")->setTargets(
                ""
            )->setDuration("instantaneous")->setSavingThrow("Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Limited Wish")->setLongDescription(
            "A limited wish lets you create nearly any type of effect. For example, a limited wish can do any of the following things. * Duplicate any sorcerer/wizard spell of 6th level or lower, provided the spell does not belong to one of your opposition schools.* Duplicate any non-sorcerer/wizard spell of 5th level or lower, provided the spell does not belong to one of your opposition schools.* Duplicate any sorcerer/wizard spell of 5th level or lower, even if it belongs to one of your opposition schools.* Duplicate any non-sorcerer/wizard spell of 4th level or lower, even if it belongs to one of your opposition schools. * Undo the harmful effects of many spells, such as or <a href=\"Insanity\">insanity</a>.* Produce any other effect whose power level is in line with the above effects, such as a single creature automatically hitting on its next attack or taking a -7 penalty on its next saving throw.A duplicated spell allows saving throws and spell resistance as normal, but the save DC is for a 7th-level spell. When a limited wish spell duplicates a spell with a material component that costs more than 1,000 gp, you must provide that component (in addition to the 1,500 gp diamond component for this spell)."
        )->setCastingTime("1 standard action")->setComponents("diamond worth 1,500 gp")->setRange(
                "see text"
            )->setTargets("see text")->setDuration("see text")->setSavingThrow("none, see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Liveoak")->setLongDescription(
            "This spell turns an oak tree into a protector or guardian. The spell can only be cast on a single tree at a time; while liveoak is in effect, you can't cast it again on another tree. Liveoak must be cast on a healthy, Huge oak. A triggering phrase of up to one word per caster level is placed on the targeted oak. The liveoak spell triggers the tree into animating as a treant.  If liveoak is dispelled, the tree takes root immediately wherever it happens to be. If released by you, the tree tries to return to its original location before taking root."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("touch")->setTargets("tree touched")->setDuration(
                "1 day/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Locate Creature")->setLongDescription(
            "This spell functions like <a href=\"Locate Object\">locate object</a>, except this spell locates a known creature. You slowly turn and sense when you are facing in the direction of the creature to be located, provided it is within range. You also know in which direction the creature is moving, if any. The spell can locate a creature of a specific kind or a specific creature known to you. It cannot find a creature of a certain type. To find a kind of creature, you must have seen such a creature up close (within 30 feet) at least once. Running water blocks the spell. It cannot detect objects. It can be fooled by <a href=\"Mislead\">mislead</a>, <a href=\"Nondetection\">nondetection</a>, and <a href=\"Polymorph\">polymorph</a> spells."
        )->setCastingTime("")->setComponents("fur from a bloodhound")->setRange("")->setTargets("")->setDuration(
                "10 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Locate Object")->setLongDescription(
            "You sense the direction of a well-known or clearly visualized object. You can search for general items, in which case you locate the nearest of its kind if more than one is within range. Attempting to find a certain item requires a specific and accurate mental image; if the image is not close enough to the actual object, the spell fails. You cannot specify a unique item unless you have observed that particular item firsthand (not through divination). The spell is blocked by even a thin sheet of lead. Creatures cannot be found by this spell. <a href=\"Polymorph\">Polymorph</a> any object and <a href=\"Nondetection\">nondetection</a> fool it."
        )->setCastingTime("1 standard action")->setComponents("a forked twig")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Longstrider")->setLongDescription(
            "This spell gives you a +10 foot enhancement bonus to your base speed. It has no effect on other modes of movement, such as burrow, climb, fly, or swim."
        )->setCastingTime("1 standard action")->setComponents("a pinch of dirt")->setRange("personal")->setTargets(
                "you"
            )->setDuration("1 hour/level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Lullaby")->setLongDescription(
            "Any creature within the area that fails a Will save becomes drowsy and inattentive, taking a -5 penalty on Perception checks and a -2 penalty on Will saves against sleep effects while the lullaby is in effect. Lullaby lasts for as long as the caster concentrates, plus up to 1 round per caster level thereafter."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("concentration + 1 round/level (D)")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage Armor")->setLongDescription(
            "An invisible but tangible field of force surrounds the subject of a mage armor spell, providing a +4 armor bonus to AC. Unlike mundane armor, mage armor entails no armor check penalty, arcane spell failure chance, or speed reduction. Since mage armor is made of force, incorporeal creatures can't bypass it the way they do normal armor."
        )->setCastingTime("1 standard action")->setComponents("a piece of cured leather")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 hour/level (D)")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage Hand")->setLongDescription(
            "You point your finger at an object and can lift it and move it at will from a distance. As a move action, you can propel the object as far as 15 feet in any direction, though the spell ends if the distance between you and the object ever exceeds the spell's range."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one nonmagical, unattended object weighing up to 5 lbs.")->setDuration(
                "concentration"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage's Disjunction")->setLongDescription(
            "All magical effects and magic items within the radius of the spell, except for those that you carry or touch, are disjoined. That is, spells and spell-like effects are unraveled and destroyed completely (ending the effect as a <a href=\"Dispel Magic\">dispel magic</a> spell does), and each permanent magic item must make a successful Will save or be turned into a normal item for the duration of this spell. An item in a creature's possession uses its own Will save bonus or its possessor's Will save bonus, whichever is higher. If an item's saving throw results in a natural 1 on the die, the item is destroyed instead of being suppressed. You also have a 1% chance per caster level of destroying an <a href=\"Antimagic Field\">antimagic field</a>. If the <a href=\"Antimagic Field\">antimagic field</a> survives the disjunction, no items within it are disjoined. You can also use this spell to target a single item. The item gets a Will save at a -5 penalty to avoid being permanently destroyed. Even artifacts are subject to mage's disjunction, though there is only a 1% chance per caster level of actually affecting such powerful items. If successful, the artifact's power unravels, and it is destroyed (with no save). If an artifact is destroyed, you must make a DC 25 Will save or permanently lose all spellcasting abilities. These abilities cannot be recovered by mortal magic, not even <a href=\"Miracle\">miracle</a> or <a href=\"Wish\">wish</a>. Destroying artifacts is a dangerous business, and it is 95% likely to attract the attention of some powerful being who has an interest in or connection with the device."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 minute/level")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage's Faithful Hound")->setLongDescription(
            "You conjure up a phantom watchdog that is invisible to everyone but yourself. It then guards the area where it was conjured (it does not move). The hound immediately starts barking loudly if any Small or larger creature approaches within 30 feet of it. (Those within 30 feet of the hound when it is conjured may move about in the area, but if they leave and return, they activate the barking.) The hound sees invisible and ethereal creatures. It does not react to figments, but it does react to shadow illusions. If an intruder approaches to within 5 feet of the hound, the dog stops barking and delivers a vicious bite (+10 attack bonus, 2d6+3 points of piercing damage) once per round. The dog also gets the bonuses appropriate to an invisible creature (see invisibility). The dog is considered ready to bite intruders, so it delivers its first bite on the intruder's turn. Its bite is the equivalent of a magic weapon for the purpose of damage reduction. The hound cannot be attacked, but it can be dispelled. The spell lasts for 1 hour per caster level, but once the hound begins barking, it lasts only 1 round per caster level. If you are ever more than 100 feet distant from the hound, the spell ends."
        )->setCastingTime("1 standard action")->setComponents(
                "a tiny silver whistle, a piece of bone, and a thread"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration(
                "1 hour/caster level or until discharged, then 1 round/caster level; see text"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage's Lucubration")->setLongDescription(
            "You instantly prepare any one spell of 5th level or lower that you have used during the past 24 hours. The spell must have been actually cast during that period. The chosen spell is stored in your mind as through prepared in the normal fashion. If the recalled spell requires material components, you must provide them. The recovered spell is not usable until the material components are available."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "instantaneous"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage's Magnificent Mansion")->setLongDescription(
            "You conjure up an extradimensional dwelling that has a single entrance on the plane from which the spell was cast. The entry point looks like a faint shimmering in the air that is 4 feet wide and 8 feet high. Only those you designate may enter the mansion, and the portal is shut and made invisible behind you when you enter. You may open it again from your own side at will. Once observers have passed beyond the entrance, they are in a magnificent foyer with numerous chambers beyond. The atmosphere is clean, fresh, and warm. You can create any floor plan you desire to the limit of the spell's effect. The place is furnished and contains sufficient foodstuffs to serve a nine-course banquet to a dozen people per caster level. A staff of near-transparent servants (as many as two per caster level), liveried and obedient, wait upon all who enter. The servants function as <a href=\"Unseen Servant\">unseen servant</a> spells except that they are visible and can go anywhere in the mansion. Since the place can be entered only through its special portal, outside conditions do not affect the mansion, nor do conditions inside it pass to the plane beyond."
        )->setCastingTime("1 standard action")->setComponents(
                "a miniature ivory door, a piece of polished marble, and a silver spoon, each worth 5 gp"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration(
                "2 hours/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage's Private Sanctum")->setLongDescription(
            "This spell ensures privacy. Anyone looking into the area from outside sees only a dark, foggy mass. Darkvision cannot penetrate it. No sounds, no matter how loud, can escape the area, so nobody can eavesdrop from outside. Those inside can see out normally. Divination (scrying) spells cannot perceive anything within the area, and those within are immune to <a href=\"Detect Thoughts\">detect thoughts</a>. The ward prevents speech between those inside and those outside (because it blocks sound), but it does not prevent other communication, such as a <a href=\"Sending\">sending</a> or <a href=\"Message\">message</a> spell, or telepathic communication, such as that between a wizard and her familiar. The spell does not prevent creatures or objects from moving into and out of the area. Mage's private sanctum can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("10 minutes")->setComponents(
                "a sheet of lead, a piece of glass, a wad of cotton, and powdered chrysolite"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration("24 hours (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mage's Sword")->setLongDescription(
            "This spell brings into being a shimmering, sword-like plane of force. The sword strikes at any opponent within its range, as you desire, starting in the round that you cast the spell. The sword attacks its designated target once each round on your turn. Its attack bonus is equal to your caster level + your Intelligence bonus or your Charisma bonus (for wizards or sorcerers, respectively) with an additional +3 enhancement bonus. As a force effect, it can strike ethereal and incorporeal creatures. It deals 4d6+3 points of force damage, with a threat range of 19-20 and a critical multiplier of x2. The sword always strikes from your direction. It does not get a bonus for flanking or help a combatant get one. If the sword goes beyond the spell range from you, goes out of your sight, or you are not directing it, it returns to you and hovers. Each round after the first, you can use a standard action to switch the sword to a new target. If you do not, the sword continues to attack the previous round's target. The sword cannot be attacked or harmed by physical attacks, but <a href=\"Dispel Magic\">dispel magic</a>, <a href=\"Disintegrate\">disintegrate</a>, a sphere of annihilation, or a rod of cancellation affects it. The sword's AC is 13 (10, +0 size bonus for Medium object, +3 deflection bonus). If an attacked creature has spell resistance, the resistance is checked the first time mage's sword strikes it. If the sword is successfully resisted, the spell is dispelled. If not, the sword has its normal full effect on that creature for the duration of the spell."
        )->setCastingTime("1 standard action")->setComponents("a miniature platinum sword worth 250 gp")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Aura")->setLongDescription(
            "You alter an item's aura so that it registers to detect spells (and spells with similar capabilities) as though it were nonmagical, or a magic item of a kind you specify, or the subject of a spell you specify. If the object bearing magic aura has identify cast on it or is similarly examined, the examiner recognizes that the aura is false and detects the object's actual qualities if he succeeds on a Will save. Otherwise, he believes the aura and no amount of testing reveals what the true magic is. If the targeted item's own aura is exceptionally powerful (if it is an artifact, for instance), magic aura doesn't work. Note: A magic weapon, shield, or suit of armor must be a masterwork item, so a sword of average make, for example, looks suspicious if it has a magical aura."
        )->setCastingTime("1 standard action")->setComponents(
                "a small square of silk that must be passed over the object that receives the aura"
            )->setRange("touch")->setTargets("one touched object weighing up to 5 lbs./level")->setDuration(
                "1 day/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Circle against Chaos")->setLongDescription(
            "This spell functions like <a href=\"Magic Circle against Evil\">magic circle against evil</a>, except that it is similar to <a href=\"Protection from Chaos\">protection from chaos</a> instead of <a href=\"Protection from Evil\">protection from evil</a>, and it can imprison a nonlawful called creature."
        )->setCastingTime("1 standard action")->setComponents("a 3-ft.-diameter circle of powdered silver")->setRange(
                "touch"
            )->setTargets("")->setDuration("10 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Circle against Evil")->setLongDescription(
            "All creatures within the area gain the effects of a <a href=\"Protection from Evil\">protection from evil</a> spell, and evil summoned creatures cannot enter the area either. Creatures in the area, or who later enter the area, receive only one attempt to suppress effects that are controlling them. If successful, such effects are suppressed as long as they remain in the area. Creatures that leave the area and come back are not protected. You must overcome a creature's spell resistance in order to keep it at bay (as in the third function of protection from evil), but the deflection and resistance bonuses and the protection from mental control apply regardless of enemies' spell resistance. This spell has an alternative version that you may choose when casting it. A magic circle against evil can be focused inward rather than outward. When focused inward, the spell binds a nongood called creature (such as those called by the <a href=\"Planar Binding, Lesser\">lesser planar binding</a>, <a href=\"Planar Binding\">planar binding</a>, and <a href=\"Planar Binding, Greater\">greater planar binding</a> spells) for a maximum of 24 hours per caster level, provided that you cast the spell that calls the creature within 1 round of casting the magic circle. The creature cannot cross the circle's boundaries. If a creature too large to fit into the spell's area is the subject of the spell, the spell acts as a normal <a href=\"Protection from Evil\">protection from evil</a> spell for that creature only. A magic circle leaves much to be desired as a trap. If the circle of powdered silver laid down in the process of spellcasting is broken, the effect immediately ends. The trapped creature can do nothing that disturbs the circle, directly or indirectly, but other creatures can. If the called creature has spell resistance, it can test the trap once a day. If you fail to overcome its spell resistance, the creature breaks free, destroying the circle. A creature capable of any form of dimensional travel (astral projection, <a href=\"Blink\">blink</a>, <a href=\"Dimension Door\">dimension door</a>, <a href=\"Etherealness\">etherealness</a>, <a href=\"Gate\">gate</a>, <a href=\"Plane Shift\">plane shift</a>, <a href=\"Shadow Walk\">shadow walk</a>, <a href=\"Teleport\">teleport</a>, and similar abilities) can simply leave the circle through such means. You can prevent the creature's extradimensional escape by casting a <a href=\"Dimensional Anchor\">dimensional anchor</a> spell on it, but you must cast the spell before the creature acts. If you are successful, the anchor effect lasts as long as the magic circle does. The creature cannot reach across the magic circle, but its ranged attacks (ranged weapons, spells, magical abilities, and the like) can. The creature can attack any target it can reach with its ranged attacks except for the circle itself. You can add a special diagram (a two-dimensional bounded figure with no gaps along its circumference, augmented with various magical sigils) to make the magic circle more secure. Drawing the diagram by hand takes 10 minutes and requires a DC 20 Spellcraft check. You do not know the result of this check. If the check fails, the diagram is ineffective. You can take 10 when drawing the diagram if you are under no particular time pressure to complete the task. This task also takes 10 full minutes. If time is no factor at all, and you devote 3 hours and 20 minutes to the task, you can take 20. A successful diagram allows you to cast a <a href=\"Dimensional Anchor\">dimensional anchor</a> spell on the magic circle during the round before casting any summoning spell. The anchor holds any called creatures in the magic circle for 24 hours per caster level. A creature cannot use its spell resistance against a magic circle prepared with a diagram, and none of its abilities or attacks can cross the diagram. If the creature tries a Charisma check to break free of the trap (see the <a href=\"Planar Binding, Lesser\">lesser planar binding</a> spell), the DC increases by 5. The creature is immediately released if anything disturbs the diagram--even a straw laid across it. The creature itself cannot disturb the diagram either directly or indirectly, as noted above. This spell is not cumulative with <a href=\"Protection from Evil\">protection from evil</a> and vice versa."
        )->setCastingTime("1 standard action")->setComponents("a 3-ft.-diameter circle of powdered silver")->setRange(
                "touch"
            )->setTargets("")->setDuration("10 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Circle against Good")->setLongDescription(
            "This spell functions like <a href=\"Magic Circle against Evil\">magic circle against evil</a>, except that it is similar to <a href=\"Protection from Good\">protection from good</a> instead of <a href=\"Protection from Evil\">protection from evil</a>, and it can imprison a nonevil called creature."
        )->setCastingTime("1 standard action")->setComponents("a 3-ft.-diameter circle of powdered silver")->setRange(
                "touch"
            )->setTargets("")->setDuration("10 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Circle against Law")->setLongDescription(
            "This spell functions like <a href=\"Magic Circle against Evil\">magic circle against evil</a>, except that it is similar to <a href=\"Protection from Law\">protection from law</a> instead of <a href=\"Protection from Evil\">protection from evil</a>, and it can imprison a nonchaotic called creature."
        )->setCastingTime("1 standard action")->setComponents("a 3-ft.-diameter circle of powdered silver")->setRange(
                "touch"
            )->setTargets("")->setDuration("10 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Fang")->setLongDescription(
            "Magic fang gives one natural weapon or unarmed strike of the subject a +1 enhancement bonus on attack and damage rolls. The spell can affect a slam attack, fist, bite, or other natural weapon. The spell does not change an unarmed strike's damage from nonlethal damage to lethal damage. Magic fang can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Fang, Greater")->setLongDescription(
            "This spell functions like <a href=\"Magic Fang\">magic fang</a>, except that the enhancement bonus on attack and damage rolls is +1 per four caster levels (maximum +5). This bonus does not allow a natural weapon or unarmed strike to bypass damage reduction aside from magic. Alternatively, you may imbue all of the creature's natural weapons with a +1 enhancement bonus (regardless of your caster level). Greater magic fang can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("1 hour/level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Jar")->setLongDescription(
            "By casting magic jar, you place your soul in a gem or large crystal (known as the magic jar), leaving your body lifeless. Then you can attempt to take control of a nearby body, forcing its soul into the magic jar. You may move back to the jar (thereby returning the trapped soul to its body) and attempt to possess another body. The spell ends when you send your soul back to your own body, leaving the receptacle empty. To cast the spell, the magic jar must be within spell range and you must know where it is, though you do not need line of sight or line of effect to it. When you transfer your soul upon casting, your body is, as near as anyone can tell, dead.  While in the magic jar, you can sense and attack any life force within 10 feet per caster level (and on the same plane of existence). You do need line of effect from the jar to the creatures. You cannot determine the exact creature types or positions of these creatures. In a group of life forces, you can sense a difference of 4 or more HD between one creature and another and can determine whether a life force is powered by positive or negative energy. (Undead creatures are powered by negative energy. Only sentient undead creatures have, or are, souls.) You could choose to take over either a stronger or a weaker creature, but which particular stronger or weaker creature you attempt to possess is determined randomly. Attempting to possess a body is a full-round action. It is blocked by <a href=\"Protection from Evil\">protection from evil</a> or a similar ward. You possess the body and force the creature's soul into the magic jar unless the subject succeeds on a Will save. Failure to take over the host leaves your life force in the magic jar, and the target automatically succeeds on further saving throws if you attempt to possess its body again. If you are successful, your life force occupies the host body, and the host's life force is imprisoned in the magic jar. You keep your Intelligence, Wisdom, Charisma, level, class, base attack bonus, base save bonuses, alignment, and mental abilities. The body retains its Strength, Dexterity, Constitution, hit points, natural abilities, and automatic abilities. A body with extra limbs does not allow you to make more attacks (or more advantageous two-weapon attacks) than normal. You can't choose to activate the body's extraordinary or supernatural abilities. The creature's spells and spell-like abilities do not stay with the body. As a standard action, you can shift freely from a host to the magic jar if within range, sending the trapped soul back to its body. The spell ends when you shift from the jar to your own body. If the host body is slain, you return to the magic jar, if within range, and the life force of the host departs (it is dead). If the host body is slain beyond the range of the spell, both you and the host die. Any life force with nowhere to go is treated as slain. If the spell ends while you are in the magic jar, you return to your body (or die if your body is out of range or destroyed). If the spell ends while you are in a host, you return to your body (or die, if it is out of range of your current position), and the soul in the magic jar returns to its body (or dies if it is out of range). Destroying the receptacle ends the spell, and the spell can be dispelled at either the magic jar or the host's location."
        )->setCastingTime("1 standard action")->setComponents("a gem or crystal worth at least 100 gp")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one creature")->setDuration("1 hour/level or until you return to your body")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Missile")->setLongDescription(
            "A missile of magical energy darts forth from your fingertip and strikes its target, dealing 1d4+1 points of force damage. The missile strikes unerringly, even if the target is in melee combat, so long as it has less than total cover or total concealment. Specific parts of a creature can't be singled out. Objects are not damaged by the spell. For every two caster levels beyond 1st, you gain an additional missile--two at 3rd level, three at 5th, four at 7th, and the maximum of five missiles at 9th level or higher. If you shoot multiple missiles, you can have them strike a single creature or several creatures. A single missile can strike only one creature. You must designate targets before you check for spell resistance or roll damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("up to five creatures, no two of which can be more than 15 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Mouth")->setLongDescription(
            "This spell imbues the chosen object or creature with an enchanted mouth that suddenly appears and speaks its message the next time a specified event occurs. The message, which must be 25 or fewer words long, can be in any language known by you and can be delivered over a period of 10 minutes. The mouth cannot utter verbal components, use command words, or activate magical effects. It does, however, move according to the words articulated; if it were placed upon a statue, the mouth of the statue would move and appear to speak. Magic mouth can also be placed upon a tree, rock, or any other object or creature. The spell functions when specific conditions are fulfilled according to your command as set in the spell. Commands can be as general or as detailed as desired, although only visual and audible triggers can be used. Triggers react to what appears to be the case. Disguises and illusions can fool them. Normal darkness does not defeat a visual trigger, but magical <a href=\"Darkness\">darkness</a> or <a href=\"Invisibility\">invisibility</a> does. Silent movement or magical <a href=\"Silence\">silence</a> defeats audible triggers. Audible triggers can be keyed to general types of noises or to a specific noise or spoken word. Actions can serve as triggers if they are visible or audible. A magic mouth cannot distinguish alignment, level, Hit Dice, or class except by external garb. The range limit of a trigger is 15 feet per caster level, so a 6th-level caster can command a magic mouth to respond to triggers as far as 90 feet away. Regardless of range, the mouth can respond only to visible or audible triggers and actions in line of sight or within hearing distance. Magic mouth can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents(
                "a small bit of honeycomb and jade dust worth 10 gp"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("one creature or object")->setDuration(
                "permanent until discharged"
            )->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Stone")->setLongDescription(
            "You transmute as many as three pebbles, which can be no larger than sling bullets, so that they strike with great force when thrown or slung. If hurled, they have a range increment of 20 feet. If slung, treat them as sling bullets (range increment 50 feet). The spell gives them a +1 enhancement bonus on attack and damage rolls. The user of the stones makes a normal ranged attack. Each stone that hits deals 1d6+1 points of damage (including the spell's enhancement bonus), or 2d6+2 points against undead."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "up to three pebbles touched"
            )->setDuration("30 minutes or until discharged")->setSavingThrow(
                "Will negates (harmless, object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Vestment")->setLongDescription(
            "You imbue a suit of armor or a shield with an enhancement bonus of +1 per four caster levels (maximum +5 at 20th level). An outfit of regular clothing counts as armor that grants no AC bonus for the purpose of this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "armor or shield touched"
            )->setDuration("1 hour/level")->setSavingThrow("Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Weapon")->setLongDescription(
            "Magic weapon gives a weapon a +1 enhancement bonus on attack and damage rolls. An enhancement bonus does not stack with a masterwork weapon's +1 bonus on attack rolls. You can't cast this spell on a natural weapon, such as an unarmed strike (instead, see magic fang). A monk's unarmed strike is considered a weapon, and thus it can be enhanced by this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "weapon touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Magic Weapon, Greater")->setLongDescription(
            "This spell functions like <a href=\"Magic Weapon\">magic weapon</a>, except that it gives a weapon an enhancement bonus on attack and damage rolls of +1 per four caster levels (maximum +5). This bonus does not allow a weapon to bypass damage reduction aside from magic. Alternatively, you can affect as many as 50 arrows, bolts, or bullets. The projectiles must be of the same kind, and they have to be together (in the same quiver or other container). Projectiles, but not thrown weapons, lose their transmutation after they are used. Treat shuriken as projectiles, rather than as thrown weapons, for the purpose of this spell."
        )->setCastingTime("1 standard action")->setComponents("powdered lime and carbon")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "one weapon or 50 projectiles (all of which must be together at the time of casting)"
            )->setDuration("1 hour/level")->setSavingThrow("Will negates (harmless, object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Major Creation")->setLongDescription(
            "This spell functions like <a href=\"Minor Creation\">minor creation</a>, except that you can also create an object of mineral nature: stone, crystal, metal, or the like. The duration of the created item varies with its relative hardness and rarity, as indicated on the following table. <table><tr><th>Hardness and Rarity Examples</th><th>Duration</th></tr><tr><td>Vegetable matter</td><td>2 hr./level</td></tr><tr class=\"alt\"><td>Stone, crystal, base metals</td><td>1 hr./level</td></tr><tr><td>Precious metals</td><td>20 min./level</td></tr><tr class=\"alt\"><td>Gems</td><td>10 min./level</td></tr><tr><td>Rare metal*</td><td>1 round/level</td></tr></table><i>* Includes adamantine, alchemical silver, and mithral. You can't use major creation to create a cold iron item.</i>"
        )->setCastingTime(": 10 minutes")->setComponents(
                "a tiny piece of matter of the same sort of item you plan to create with minor creation"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration("see text")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Major Image")->setLongDescription(
            "This spell functions like <a href=\"Silent Image\">silent image</a>, except that sound, smell, and thermal illusions are included in the spell effect. While concentrating, you can move the image within the range.  The image disappears when struck by an opponent unless you cause the illusion to react appropriately."
        )->setCastingTime("1 standard action")->setComponents("a bit of fleece")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("Concentration + 3 rounds")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Make Whole")->setLongDescription(
            "This spell functions as <a href=\"Mending\">mending</a>, except that it repairs 1d6 points of damage per level when cast on a construct creature (maximum 5d6). Make whole can fix destroyed magic items (at 0 hit points or less), and restores the magic properties of the item if your caster level is at least twice that of the item. Items with charges (such as wands) and single-use items (such as potions and scrolls) cannot be repaired in this way. When make whole is used on a construct creature, the spell bypasses any immunity to magic as if the spell did not allow spell resistance."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                "one object of up to 10 cu. ft./level or one construct creature of any size"
            )->setDuration("instantaneous")->setSavingThrow(": Will negates (harmless, object)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mark of Justice")->setLongDescription(
            "You mark a subject and state some behavior on the part of the subject that will activate the mark. When activated, the mark curses the subject. Typically, you designate some sort of undesirable behavior that activates the mark, but you can pick any act you please. The effect of the mark is identical with the effect of <a href=\"Bestow Curse\">bestow curse</a>. Since this spell takes 10 minutes to cast and involves writing on the target, you can cast it only on a creature that is willing or restrained. Like the effect of <a href=\"Bestow Curse\">bestow curse</a>, a mark of justice cannot be dispelled, but it can be removed with a <a href=\"Break Enchantment\">break enchantment</a>, <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, <a href=\"Remove Curse\">remove curse</a>, or <a href=\"Wish\">wish</a> spell. <a href=\"Remove Curse\">Remove curse</a> works only if its caster level is equal to or higher than your mark of justice caster level. These restrictions apply regardless of whether the mark has activated."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("permanent; see text")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Maze")->setLongDescription(
            "You banish the subject into an extradimensional labyrinth. Each round on its turn, it may attempt a DC 20 Intelligence check to escape the labyrinth as a full-round action. If the subject doesn't escape, the maze disappears after 10 minutes, freeing the subject. On escaping or leaving the maze, the subject reappears where it had been when the maze spell was cast. If this location is filled with a solid object, the subject appears in the nearest open space. Spells and abilities that move a creature within a plane, such as <a href=\"Teleport\">teleport</a> and <a href=\"Dimension Door\">dimension door</a>, do not help a creature escape a maze spell, although a <a href=\"Plane Shift\">plane shift</a> spell allows it to exit to whatever plane is designated in that spell. Minotaurs are not affected by this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature")->setDuration("see text")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Meld into Stone")->setLongDescription(
            "Meld into stone enables you to meld your body and possessions into a single block of stone. The stone must be large enough to accommodate your body in all three dimensions. When the casting is complete, you and not more than 100 pounds of nonliving gear merge with the stone. If either condition is violated, the spell fails and is wasted. While in the stone, you remain in contact, however tenuous, with the face of the stone through which you melded. You remain aware of the passage of time and can cast spells on yourself while hiding in the stone. Nothing that goes on outside the stone can be seen, but you can still hear what happens around you. Minor physical damage to the stone does not harm you, but its partial destruction (to the extent that you no longer fit within it) expels you and deals you 5d6 points of damage. The stone's complete destruction expels you and slays you instantly unless you make a DC 18 Fortitude save. Even if you make your save, you still take 5d6 points of damage. Any time before the duration expires, you can step out of the stone through the surface that you entered. If the spell's duration expires or the effect is dispelled before you voluntarily exit the stone, you are violently expelled and take 5d6 points of damage. The following spells harm you if cast upon the stone that you are occupying. <a href=\"Stone to Flesh\">Stone to flesh</a> expels you and deals you 5d6 points of damage. <a href=\"Stone Shape\">Stone shape</a> deals 3d6 points of damage but does not expel you. <a href=\"Transmute Rock to Mud\">Transmute rock to mud</a> expels you and then slays you instantly unless you make a DC 18 Fortitude save, in which case you are merely expelled. Finally, <a href=\"Passwall\">passwall</a> expels you without damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "10 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mending")->setLongDescription(
            "This spell repairs damaged objects, restoring 1d4 hit points to the object. If the object has the broken condition, this condition is removed if the object is restored to at least half its original hit points. All of the pieces of an object must be present for this spell to function. Magic items can be repaired by this spell, but you must have a caster level equal to or higher than that of the object. Magic items that are destroyed (at 0 hit points or less) can be repaired with this spell, but this spell does not restore their magic abilities. This spell does not affect creatures (including constructs). This spell has no effect on objects that have been warped or otherwise transmuted, but it can still repair damage done to such items."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("10 ft.")->setTargets(
                "one object of up to 1 lb./level"
            )->setDuration("instantaneous")->setSavingThrow(": Will negates (harmless, object)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Message")->setLongDescription(
            "You can whisper messages and receive whispered replies. Those nearby can hear these messages with a DC 25 Perception check. You point your finger at each creature you want to receive the message. When you whisper, the whispered message is audible to all targeted creatures within range. Magical <a href=\"Silence\">silence</a>, 1 foot of stone, 1 inch of common metal (or a thin sheet of lead), or 3 feet of wood or dirt blocks the spell. The message does not have to travel in a straight line. It can circumvent a barrier if there is an open path between you and the subject, and the path's entire length lies within the spell's range. The creatures that receive the message can whisper a reply that you hear. The spell transmits sound, not meaning; it doesn't transcend language barriers. To speak a message, you must mouth the words and whisper."
        )->setCastingTime("1 standard action")->setComponents("a piece of copper wire")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one creature/level")->setDuration("10 min./level")->setSavingThrow(
                "none"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Meteor Swarm")->setLongDescription(
            "Meteor swarm is a very powerful and spectacular spell that is similar to <a href=\"Fireball\">fireball</a> in many aspects. When you cast it, four 2-foot-diameter spheres spring from your outstretched hand and streak in straight lines to the spots you select. The meteor spheres leave a fiery trail of sparks. If you aim a sphere at a specific creature, you may make a ranged touch attack to strike the target with the meteor. Any creature struck by a sphere takes 2d6 points of bludgeoning damage (no save) and takes a -4 penalty on the saving throw against the sphere's fire damage (see below). If a targeted sphere misses its target, it simply explodes at the nearest corner of the target's space. You may aim more than one sphere at the same target. Once a sphere reaches its destination, it explodes in a 40-foot-radius spread, dealing 6d6 points of fire damage to each creature in the area. If a creature is within the area of more than one sphere, it must save separately against each. Despite stemming from separate spheres, all of the fire damage is added together after the saves have been made, and fire resistance is applied only once."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow(
                "none or Reflex half, see text"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mind Blank")->setLongDescription(
            "The subject is protected from all devices and spells that gather information about the target through <a href=\"Divination\">divination</a> magic (such as <a href=\"Detect Evil\">detect evil</a>, <a href=\"Locate Creature\">locate creature</a>, scry, and see invisible). This spell also grants a +8 resistance bonus on saving throws against all mind-affecting spells and effects. Mind blank even foils <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, and <a href=\"Wish\">wish</a> spells when they are used in such a way as to gain information about the target. In the case of scrying that scans an area the creature is in, such as <a href=\"Arcane Eye\">arcane eye</a>, the spell works but the creature simply isn't detected. Scrying attempts that are targeted specifically at the subject do not work at all."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature")->setDuration("24 hours")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mind Fog")->setLongDescription(
            "Mind fog produces a bank of thin mist that weakens the mental resistance of those caught in it. Creatures in the mind fog take a -10 penalty on Wisdom checks and Will saves. (A creature that successfully saves against the fog is not affected and need not make further saves even if it remains in the fog.) Affected creatures take the penalty as long as they remain in the fog and for 2d6 rounds thereafter. The fog is stationary and lasts for 30 minutes (or until dispersed by wind). A moderate wind (11+ mph) disperses the fog in 4 rounds; a strong wind (21+ mph) disperses the fog in 1 round. The fog is thin and does not significantly hamper vision."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("30 minutes and 2d6 rounds; see text")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Minor Creation")->setLongDescription(
            "You create a nonmagical, unattended object of nonliving vegetable matter. The volume of the item created cannot exceed 1 cubic foot per caster level. You must succeed on an appropriate Craft skill check to make a complex item. Attempting to use any created object as a material component causes the spell to fail."
        )->setCastingTime("1 minute")->setComponents(
                "a tiny piece of matter of the same sort of item you plan to create with minor creation"
            )->setRange("0 ft.")->setTargets("")->setDuration("1 hour/level (D)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Minor Image")->setLongDescription(
            "This spell functions like <a href=\"Silent Image\">silent image</a>, except that minor image includes some minor sounds but not understandable speech."
        )->setCastingTime("1 standard action")->setComponents("a bit of fleece")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("concentration + 2 rounds")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Miracle")->setLongDescription(
            "You don't so much cast a miracle as request one. You state what you would like to have happen and request that your deity (or the power you pray to for spells) intercede. A miracle can do any of the following things. * Duplicate any cleric spell of 8th level or lower. * Duplicate any other spell of 7th level or lower. * Undo the harmful effects of certain spells, such as <a href=\"Feeblemind\">feeblemind</a> or <a href=\"Insanity\">insanity</a>. * Have any effect whose power level is in line with the above effects. Alternatively, a cleric can make a very powerful request. Casting such a miracle costs the cleric 25,000 gp in powdered diamond because of the powerful divine energies involved. Examples of especially powerful miracles of this sort could include the following: * Swinging the tide of a battle in your favor by raising fallen allies to continue fighting. * Moving you and your allies, with all your and their gear, from one plane to a specific locale through planar barriers with no chance of error. * Protecting a city from an <a href=\"Earthquake\">earthquake</a>, volcanic eruption, flood, or other major natural disaster.In any event, a request that is out of line with the deity's (or alignment's) nature is refused. A duplicated spell allows saving throws and spell resistance as normal, but the save DCs are as for a 9th-level spell. When a miracle spell duplicates a spell with a material component that costs more than 100 gp, you must provide that component."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets(
                "see text"
            )->setDuration("see text")->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mirage Arcana")->setLongDescription(
            "This spell functions like <a href=\"Hallucinatory Terrain\">hallucinatory terrain</a>, except that it enables you to make any area appear to be something other than it is. The illusion includes audible, visual, tactile, and olfactory elements. Unlike <a href=\"Hallucinatory Terrain\">hallucinatory terrain</a>, the spell can alter the appearance of structures (or add them where none are present). Still, it can't disguise, conceal, or add creatures (though creatures within the area might hide themselves within the illusion just as they can hide themselves within a real location)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("")->setTargets("")->setDuration(
                "concentration +1 hour/ level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mirror Image")->setLongDescription(
            "This spell creates a number of illusory doubles of you that inhabit your square. These doubles make it difficult for enemies to precisely locate and attack you.  When mirror image is cast, 1d4 images plus one image per three caster levels (maximum eight images total) are created. These images remain in your space and move with you, mimicking your movements, sounds, and actions exactly. Whenever you are attacked or are the target of a spell that requires an attack roll, there is a possibility that the attack targets one of your images instead. If the attack is a hit, roll randomly to see whether the selected target is real or a figment. If it is a figment, the figment is destroyed. If the attack misses by 5 or less, one of your figments is destroyed by the near miss. Area spells affect you normally and do not destroy any of your figments. Spells and effects that do not require an attack roll affect you normally and do not destroy any of your figments. Spells that require a touch attack are harmlessly discharged if used to destroy a figment. An attacker must be able to see the figments to be fooled. If you are invisible or the attacker is blind, the spell has no effect (although the normal miss chances still apply)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Misdirection")->setLongDescription(
            "By means of this spell, you misdirect the information from divination spells that reveal auras (<a href=\"Detect Evil\">detect evil</a>, <a href=\"Detect Magic\">detect magic</a>, <a href=\"Discern Lies\">discern lies</a>, and the like). On casting the spell, you choose another object within range. For the duration of the spell, the subject of misdirection is detected as if it were the other object. Neither the subject nor the other object gets a saving throw against this effect. Detection spells provide information based on the second object rather than on the actual target of the detection unless the caster of the detection succeeds on a Will save. For instance, you could make yourself detect as a tree if one were within range at casting: not evil, not lying, not magical, neutral in alignment, and so forth. This spell does not affect other types of divination magic (<a href=\"Augury\">augury</a>, <a href=\"Detect Thoughts\">detect thoughts</a>, <a href=\"Clairaudience/Clairvoyance\">clairaudience/clairvoyance</a>, and the like)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature or object, up to a 10-ft. cube in size")->setDuration(
                "1 hour/level"
            )->setSavingThrow("none or Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mislead")->setLongDescription(
            "You become invisible (as <a href=\"Invisibility, Greater\">greater invisibility</a>, a glamer), and at the same time, an illusory double of you (as <a href=\"Major Image\">major image</a>, a figment) appears. You are then free to go elsewhere while your double moves away. The double appears within range but thereafter moves as you direct it (which requires concentration beginning on the first round after the casting). You can make the figment appear superimposed perfectly over your own body so that observers don't notice an image appearing and you turning invisible. You and the figment can then move in different directions. The double moves at your speed and can talk and gesture as if it were real, but it cannot attack or cast spells, though it can pretend to do so. The illusory double lasts as long as you concentrate upon it, plus 3 additional rounds. After you cease concentration, the illusory double continues to carry out the same activity until the duration expires. The <a href=\"Invisibility, Greater\">greater invisibility</a> lasts for 1 round per level, regardless of concentration."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("you")->setDuration(
                "1 round/level (D) and concentration + 3 rounds; see text"
            )->setSavingThrow(
                "none or Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mnemonic Enhancer")->setLongDescription(
            "Casting this spell allows you to prepare additional spells or retain spells recently cast. Pick one of these two versions when the spell is cast. Prepare: You prepare up to three additional levels of spells. A cantrip counts as 1/2 level for this purpose. You prepare and cast these spells normally. Retain: You retain any spell of 3rd level or lower that you had cast up to 1 round before you started casting the mnemonic enhancer. This restores the previously cast spell to your mind. In either event, the spell or spells prepared or retained fade after 24 hours (if not cast)."
        )->setCastingTime("10 minutes")->setComponents(
                "a piece of string, and ink consisting of squid secretion mixed with black dragon's blood & an ivory plaque worth 50 gp"
            )->setRange("personal")->setTargets("you")->setDuration("instantaneous")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Modify Memory")->setLongDescription(
            "You reach into the subject's mind and modify as many as 5 minutes of its memories in one of the following ways. * Eliminate all memory of an event the subject actually experienced. This spell cannot negate charm, <a href=\"Geas/Quest\">geas/quest</a>, <a href=\"Suggestion\">suggestion</a>, or similar spells.* Allow the subject to recall with perfect clarity an event it actually experienced.* Change the details of an event the subject actually experienced.* Implant a memory of an event the subject never experienced.Casting the spell takes 1 round. If the subject fails to save, you proceed with the spell by spending as much as 5 minutes (a period of time equal to the amount of memory you want to modify) visualizing the memory you wish to modify in the subject. If your concentration is disturbed before the visualization is complete, or if the subject is ever beyond the spell's range during this time, the spell is lost. A modified memory does not necessarily affect the subject's actions, particularly if it contradicts the creature's natural inclinations. An illogical modified memory is dismissed by the creature as a bad dream, too much wine, or another similar excuse. "
        )->setCastingTime("1 round; see text")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("permanent")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Moment of Prescience")->setLongDescription(
            "This spell grants you a sixth sense. Once during the spell's duration, you may choose to use its effect. This spell grants you an insight bonus equal to your caster level (maximum +25) on any single attack roll, combat maneuver check, opposed ability or skill check, or saving throw. Alternatively, you can apply the insight bonus to your AC against a single attack (even if flat-footed). Activating the effect doesn't take an action; you can even activate it on another character's turn. You must choose to use the moment of prescience before you make the roll it is to modify. Once used, the spell ends. You can't have more than one moment of prescience active on you at the same time."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 hour/level or until discharged"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Mount")->setLongDescription(
            "You summon a light horse or a pony (your choice) to serve you as a mount. The steed serves willingly and well. The mount comes with a bit and bridle and a riding saddle."
        )->setCastingTime("1 round")->setComponents("a bit of horse hair")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("2 hours/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Move Earth")->setLongDescription(
            "Move earth moves dirt (clay, loam, sand, and soil), possibly collapsing embankments, moving hillocks, shifting dunes, and so forth. In no event can rock formations be collapsed or moved. The area to be affected determines the casting time. For every 150-foot square (up to 10 feet deep), casting takes 10 minutes. The maximum area, 750 feet by 750 feet, takes 4 hours and 10 minutes to move. This spell does not violently break the surface of the ground. Instead, it creates wavelike crests and troughs, with the earth reacting with glacial fluidity until the desired result is achieved. Trees, structures, rock formations, and such are mostly unaffected except for changes in elevation and relative topography. The spell cannot be used for tunneling and is generally too slow to trap or bury creatures. Its primary use is for digging or filling moats or for adjusting terrain contours before a battle. This spell has no effect on earth creatures."
        )->setCastingTime("see text")->setComponents("clay, loam, sand, and an iron blade")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Neutralize Poison")->setLongDescription(
            "You detoxify any sort of venom in the creature or object touched. If the target is a creature, you must make a caster level check (1d20 + caster level) against the DC of each poison affecting the target. Success means that the poison is neutralized. A cured creature suffers no additional effects from the poison, and any temporary effects are ended, but the spell does not reverse instantaneous effects, such as hit point damage, temporary ability damage, or effects that don't go away on their own. This spell can instead neutralize the poison in a poisonous creature or object for 10 minutes per level, at the caster's option. If cast on a creature, the creature receives a Will save to negate the effect."
        )->setCastingTime("1 standard action")->setComponents("charcoal")->setRange("touch")->setTargets(
                "creature or object of up to 1 cu. ft./level touched"
            )->setDuration("instantaneous or 10 min./level; see text")->setSavingThrow(
                "Will negates (harmless, object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Nightmare")->setLongDescription(
            "You send a hideous and unsettling phantasmal vision to a specific creature that you name or otherwise specifically designate. The nightmare prevents restful sleep and causes 1d10 points of damage. The nightmare leaves the subject fatigued and unable to regain arcane spells for the next 24 hours. The difficulty of the save depends on your knowledge the subject and the physical connection (if any) you have to that creature. <table><tr><th>Knowledge</th><th>Will Save Modifier</th></tr><tr><td>None*</td><td>+10</td></tr><tr class=\"alt\"><td>Secondhand (you have heard of the subject)</td><td>+5</td></tr><tr><td>Firsthand (you have met the subject)</td><td>+0</td></tr><tr class=\"alt\"><td>Familiar (you know the subject well)</td><td>-5</td></tr><tr><td>Connection</td><td>Will Save Modifier</td></tr><tr class=\"alt\"><td>Likeness or picture</td><td>-2</td></tr><tr><td>Possession or garment</td><td>-4</td></tr><tr class=\"alt\"><td>Body part, lock of hair, bit of nail, etc.</td><td>-10</td></tr></table><i>*You must have some sort of connection to a creature of which you have no knowledge.</i> Dispel evil cast on the subject while you are casting the spell dispels the nightmare and causes you to be stunned for 10 minutes per caster level of the <a href=\"Dispel Evil\">dispel evil</a>. If the recipient is awake when the spell begins, you can choose to cease casting (ending the spell) or to enter a trance until the recipient goes to sleep, whereupon you become alert again and complete the casting. If you are disturbed during the trance, you must succeed on a Concentration check as if you were in the midst of casting a spell or the spell ends. If you choose to enter a trance, you are not aware of your surroundings or the activities around you while in the trance. You are defenseless, both physically and mentally, while in the trance. (You always fail Reflex and Will saving throws, for example.) Creatures who don't sleep (such as elves, but not half-elves) or dream are immune to this spell."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("unlimited")->setTargets(
                "one living creature"
            )->setDuration("instantaneous")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Nondetection")->setLongDescription(
            "The warded creature or object becomes difficult to detect by <a href=\"Divination\">divination</a> spells such as <a href=\"Clairaudience/Clairvoyance\">clairaudience/clairvoyance</a>, <a href=\"Locate Object\">locate object</a>, and detect spells. Nondetection also prevents location by such magic items as crystal balls. If a <a href=\"Divination\">divination</a> is attempted against the warded creature or item, the caster of the <a href=\"Divination\">divination</a> must succeed on a caster level check (1d20 + caster level) against a DC of 11 + the caster level of the spellcaster who cast nondetection. If you cast nondetection on yourself or on an item currently in your possession, the DC is 15 + your caster level. If cast on a creature, nondetection wards the creature's gear as well as the creature itself."
        )->setCastingTime("1 standard action")->setComponents("diamond dust worth 50 gp")->setRange(
                "touch"
            )->setTargets("creature or object touched")->setDuration("1 hour/level")->setSavingThrow(
                "Will negates (harmless, object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Obscure Object")->setLongDescription(
            "This spell hides an object from location by <a href=\"Divination\">divination</a> (scrying) effects, such as the <a href=\"Scrying\">scrying</a> spell or a crystal ball. Such an attempt automatically fails (if the <a href=\"Divination\">divination</a> is targeted on the object) or fails to perceive the object (if the <a href=\"Divination\">divination</a> is targeted on a nearby location, object, or person)."
        )->setCastingTime("1 standard action")->setComponents("chameleon skin")->setRange("touch")->setTargets(
                "one object touched of up to 100 lbs./level"
            )->setDuration("8 hours (D)")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Obscuring Mist")->setLongDescription(
            "A misty vapor arises around you. It is stationary. The vapor obscures all sight, including darkvision, beyond 5 feet. A creature 5 feet away has concealment (attacks have a 20% miss chance). Creatures farther away have total concealment (50% miss chance, and the attacker cannot use sight to locate the target). A moderate wind (11+ mph), such as from a <a href=\"Gust of Wind\">gust of wind</a> spell, disperses the fog in 4 rounds. A strong wind (21+ mph) disperses the fog in 1 round. A <a href=\"Fireball\">fireball</a>, <a href=\"Flame Strike\">flame strike</a>, or similar spell burns away the fog in the explosive or fiery spell's area. A <a href=\"Wall of Fire\">wall of fire</a> burns away the fog in the area into which it deals damage. This spell does not function underwater."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("20 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Open/Close")->setLongDescription(
            "You can open or close (your choice) a door, chest, box, window, bag, pouch, bottle, barrel, or other container. If anything resists this activity (such as a bar on a door or a lock on a chest), the spell fails. In addition, the spell can only open and close things weighing 30 pounds or less. Thus, doors, chests, and similar objects sized for enormous creatures may be beyond this spell's ability to affect."
        )->setCastingTime("1 standard action")->setComponents("a brass key")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("object weighing up to 30 lbs. or portal that can be opened or closed")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Order's Wrath")->setLongDescription(
            "You channel lawful power to smite enemies. The power takes the form of a three-dimensional grid of energy. Only chaotic and neutral (not lawful) creatures are harmed by the spell. The spell deals 1d8 points of damage per two caster levels (maximum 5d8) to chaotic creatures (or 1d6 points of damage per caster level, maximum 10d6, to chaotic outsiders) and causes them to be dazed for 1 round. A successful Will save reduces the damage to half and negates the daze effect. The spell deals only half damage to creatures who are neither chaotic nor lawful, and they are not dazed. They can reduce the damage in half again (down to one-quarter of the roll) with a successful Will save."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous (1 round); see text")->setSavingThrow(
                "Will partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Overland Flight")->setLongDescription(
            "This spell functions like a <a href=\"Fly\">fly</a> spell, except you can fly at a speed of 40 feet (30 feet if wearing medium or heavy armor, or if carrying a medium or heavy load) with a bonus on Fly skill checks equal to half your caster level. When using this spell for long-distance movement, you can hustle without taking nonlethal damage (a forced march still requires Constitution checks). This means you can cover 64 miles in an 8-hour period of flight (or 48 miles at a speed of 30 feet)."
        )->setCastingTime("")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 hour/level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Owl's Wisdom")->setLongDescription(
            "The transmuted creature becomes wiser. The spell grants a +4 enhancement bonus to Wisdom, adding the usual benefit to Wisdom-related skills. Clerics, druids, and rangers (and other Wisdom-based spellcasters) who receive owl's wisdom do not gain any additional bonus spells for the increased Wisdom, but the save DCs for their spells increase."
        )->setCastingTime("1 standard action")->setComponents("feathers or droppings from an owl")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Owl's Wisdom, Mass")->setLongDescription(
            "This spell functions like <a href=\"Owl's Wisdom\">owl's wisdom</a>, except that it affects multiple creatures."
        )->setCastingTime("1 standard action")->setComponents("feathers or droppings from an owl")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Passwall")->setLongDescription(
            "You create a passage through wooden, plaster, or stone walls, but not through metal or other harder materials. The passage is 10 feet deep plus an additional 5 feet deep per three caster levels above 9th (15 feet at 12th, 20 feet at 15th, and a maximum of 25 feet deep at 18th level). If the wall's thickness is more than the depth of the passage created, then a single passwall simply makes a niche or short tunnel. Several passwall spells can then form a continuing passage to breach very thick walls. When passwall ends, creatures within the passage are ejected out the nearest exit. If someone dispels the passwall or you dismiss it, creatures in the passage are ejected out the far exit, if there is one, or out the sole exit if there is only one."
        )->setCastingTime("1 standard action")->setComponents("sesame seeds")->setRange("touch")->setTargets(
                ""
            )->setDuration("1 hour/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Pass without Trace")->setLongDescription(
            "The subject or subjects of this spell do not leave footprints or a scent trail while moving. Tracking the subjects is impossible by nonmagical means."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one creature/level touched"
            )->setDuration("1 hour/level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Permanency")->setLongDescription(
            "This spell makes the duration of certain other spells permanent. You first cast the desired spell and then follow it with the permanency spell.  Depending on the spell, you must be of a minimum caster level and must expend a specific gp value of diamond dust as a material component. You can make the following spells permanent in regard to yourself. <table><tr><th>Spell</th><th>Minimum Caster Level</th><th>GP Cost</th></tr><tr><td><a href=\"Arcane Sight\">Arcane sight</a> </td><td>11th</td><td>7,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Comprehend Languages\">Comprehend languages</a> </td><td>9th</td><td>2,500 gp</td></tr><tr><td><a href=\"Darkvision\">Darkvision</a> </td><td>10th</td><td>5,000 gp</td></tr><tr class=\"alt\"><td><a href=\"Detect Magic\">Detect magic</a> </td><td>9th</td><td>2,500 gp</td></tr><tr><td><a href=\"Read Magic\">Read magic</a> </td><td>9th</td><td>2,500 gp</td></tr><tr class=\"alt\"><td><a href=\"See Invisibility\">See invisibility</a> </td><td>10th</td><td>5,000 gp</td></tr><tr><td><a href=\"Tongues\">Tongues</a> </td><td>11th</td><td>7,500 gp</td></tr></table> You cannot cast these spells on other creatures. This application of permanency can be dispelled only by a caster of higher level than you were when you cast the spell. In addition to personal use, permanency can be used to make the following spells permanent on yourself, another creature, or an object (as appropriate). <table><tr><th>Spell</th><th>Minimum Caster Level</th><th>GP Cost</th></tr><tr><td><a href=\"Enlarge Person\">Enlarge person</a> </td><td>9th</td><td>2,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Magic Fang\">Magic fang</a></td><td>9th</td><td>2,500 gp</td></tr><tr><td><a href=\"Magic Fang, Greater\">Magic fang, greater</a> </td><td>11th</td><td>7,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Reduce Person\">Reduce person</a> </td><td>9th</td><td>2,500 gp</td></tr><tr><td><a href=\"Resistance\">Resistance</a> </td><td>9th</td><td>2,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Telepathic Bond\">Telepathic bond*</a></td><td>13th</td><td>12,500 gp</td></tr></table><i>*Only bonds two creatures per casting of permanency.</i> Additionally, the following spells can be cast upon objects or areas only and rendered permanent. <table><tr><th>Spell</th><th>Minimum Caster Level</th><th>GP Cost</th></tr><tr><td><a href=\"Alarm\">Alarm</a> </td><td>9th</td><td>2,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Animate Objects\">Animate objects</a> </td><td>14th</td><td>15,000 gp</td></tr><tr><td><a href=\"Dancing Lights\">Dancing lights</a> </td><td>9th</td><td>2,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Ghost Sound\">Ghost sound</a> </td><td>9th</td><td>2,500 gp</td></tr><tr><td><a href=\"Gust of Wind\">Gust of wind</a> </td><td>11th</td><td>7,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Invisibility\">Invisibility</a> </td><td>10th</td><td>5,000 gp</td></tr><tr><td><a href=\"Mage's Private Sanctum\">Mage's Private Sanctum</a> </td><td>13th</td><td>12,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Magic Mouth\">Magic mouth</a> </td><td>10th</td><td>5,000 gp</td></tr><tr><td><a href=\"Phase Door\">Phase door</a> </td><td>15th</td><td>17,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Prismatic Sphere\">Prismatic sphere</a> </td><td>17th</td><td>22,500 gp</td></tr><tr><td><a href=\"Prismatic Wall\">Prismatic wall</a> </td><td>16th</td><td>20,000 gp</td></tr><tr class=\"alt\"><td><a href=\"Shrink Item\">Shrink item</a> </td><td>11th</td><td>7,500 gp</td></tr><tr><td><a href=\"Solid Fog\">Solid fog</a> </td><td>12th</td><td>10,000 gp</td></tr><tr class=\"alt\"><td><a href=\"Stinking Cloud\">Stinking cloud</a> </td><td>11th</td><td>7,500 gp</td></tr><tr><td><a href=\"Symbol of Death\">Symbol of death</a> </td><td>16th</td><td>20,000 gp</td></tr><tr class=\"alt\"><td><a href=\"Symbol of Fear\">Symbol of fear</a> </td><td>14th</td><td>15,000 gp</td></tr><tr><td><a href=\"Symbol of Insanity\">Symbol of insanity</a> </td><td>16th</td><td>20,000 gp</td></tr><tr class=\"alt\"><td><a href=\"Symbol of Pain\">Symbol of pain</a> </td><td>13th</td><td>12,500 gp</td></tr><tr><td><a href=\"Symbol of Persuasion\">Symbol of persuasion</a> </td><td>14th</td><td>15,000 gp</td></tr><tr class=\"alt\"><td><a href=\"Symbol of Sleep\">Symbol of sleep</a> </td><td>16th</td><td>20,000 gp</td></tr><tr><td><a href=\"Symbol of Stunning\">Symbol of stunning</a> </td><td>15th</td><td>17,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Symbol of Weakness\">Symbol of weakness</a> </td><td>15th</td><td>17,500 gp</td></tr><tr><td><a href=\"Teleportation Circle\">Teleportation circle</a> </td><td>17th</td><td>22,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Wall of Fire\">Wall of fire</a> </td><td>12th</td><td>10,000 gp</td></tr><tr><td><a href=\"Wall of Force\">Wall of force</a> </td><td>13th</td><td>7,500 gp</td></tr><tr class=\"alt\"><td><a href=\"Web\">Web</a> </td><td>10th</td><td>5,000 gp</td></tr></table> Spells cast on other targets are vulnerable to <a href=\"Dispel Magic\">dispel magic</a> as normal. The GM may allow other spells to be made permanent."
        )->setCastingTime("2 rounds")->setComponents("see tables below")->setRange("see text")->setTargets(
                "see text"
            )->setDuration("permanent; see text")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Permanent Image")->setLongDescription(
            "This spell functions like <a href=\"Silent Image\">silent image</a>, except that the figment includes visual, auditory, olfactory, and thermal elements, and the spell is permanent. By concentrating, you can move the image within the limits of the range, but it is static while you are not concentrating."
        )->setCastingTime("1 standard action")->setComponents("a bit of fleece")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("permanent (D)")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Persistent Image")->setLongDescription(
            "This spell functions like <a href=\"Silent Image\">silent image</a>, except that the figment includes visual, auditory, olfactory, and thermal components, and the figment follows a script determined by you. The figment follows that script without your having to concentrate on it. The illusion can include intelligible speech if you wish. "
        )->setCastingTime("1 standard action")->setComponents("a bit of fleece")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Phantasmal Killer")->setLongDescription(
            "You create a phantasmal image of the most fearsome creature imaginable to the subject simply by forming the fears of the subject's subconscious mind into something that its conscious mind can visualize: this most horrible beast. Only the spell's subject can see the phantasmal killer. You see only a vague shape. The target first gets a Will save to recognize the image as unreal. If that save fails, the phantasm touches the subject, and the subject must succeed on a Fortitude save or die from fear. Even if the Fortitude save is successful, the subject takes 3d6 points of damage. If the subject of a phantasmal killer attack succeeds in disbelieving and possesses telepathy or is wearing a helm of telepathy, the beast can be turned upon you. You must then disbelieve it or become subject to its deadly fear attack."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one living creature")->setDuration("instantaneous")->setSavingThrow(
                "Will disbelief, then Fortitude partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Phantom Steed")->setLongDescription(
            "You conjure a Large, quasi-real, horselike creature (the exact coloration can be customized as you wish). It can be ridden only by you or by the one person for whom you specifically created the mount. A phantom steed has a black head and body, gray mane and tail, and smoke-colored, insubstantial hooves that make no sound. It has what seems to be a saddle, bit, and bridle. It does not fight, but animals shun it and refuse to attack it. The mount is AC 18 (-1 size, +4 natural armor, +5 Dex) and 7 hit points + 1 hit point per caster level. If it loses all its hit points, the phantom steed disappears. A phantom steed has a speed of 20 feet per two caster levels, to a maximum of 100 feet at 10th level. It can bear its rider's weight plus up to 10 pounds per caster level. These mounts gain certain powers according to caster level. A mount's abilities include those of mounts of lower caster levels.  8th Level: The mount can ride over sandy, muddy, or even swampy ground without difficulty or decrease in speed. 10th Level: The mount can use <a href=\"Water Walk\">water walk</a> at will (as the spell, no action required to activate this ability). 12th Level: The mount can use <a href=\"Air Walk\">air walk</a> at will (as the spell, no action required to activate this ability) for up to 1 round at a time, after which it falls to the ground. 14th Level: The mount can fly at its speed with a bonus on Fly skill checks equal to your caster level."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("0 ft.")->setTargets("")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Phantom Trap")->setLongDescription(
            "This spell makes a lock or other small mechanism seem to be trapped to anyone who can detect traps. You place the spell upon any small mechanism or device, such as a lock, hinge, hasp, cork, cap, or ratchet. Any character able to detect traps, or who uses any spell or device enabling trap detection, is certain a real trap exists. Of course, the effect is illusory and nothing happens if the trap is sprung; its primary purpose is to frighten away thieves or make them waste precious time. If another phantom trap is active within 50 feet when the spell is cast, the casting fails."
        )->setCastingTime("1 standard action")->setComponents("special dust worth 50 gp")->setRange(
                "touch"
            )->setTargets("object touched")->setDuration("permanent (D)")->setSavingThrow("none")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Phase Door")->setLongDescription(
            "This spell creates an ethereal passage through wooden, plaster, or stone walls, but not other materials. The phase door is invisible and inaccessible to all creatures except you, and only you can use the passage. You disappear when you enter the phase door and appear when you exit. If you desire, you can take one other creature (Medium or smaller) through the door. This counts as two uses of the door. The door does not allow light, sound, or spell effects through it, nor can you see through it without using it. Thus, the spell can provide an escape route, though certain creatures, such as phase spiders, can follow with ease. A gem of <a href=\"True Seeing\">true seeing</a> or similar magic reveals the presence of a phase door but does not allow its use. A phase door is subject to <a href=\"Dispel Magic\">dispel magic</a>. If anyone is within the passage when it is dispelled, he is harmlessly ejected just as if he were inside a <a href=\"Passwall\">passwall</a> effect. You can allow other creatures to use the phase door by setting some triggering condition for the door. Such conditions can be as simple or elaborate as you desire. They can be based on a creature's name, identity, or alignment, but otherwise must be based on observable actions or qualities. Intangibles such as level, class, HD, and hit points don't qualify. Phase door can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets("")->setDuration(
                "one usage per two levels"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Planar Ally")->setLongDescription(
            "This spell functions like <a href=\"Planar Ally, Lesser\">lesser planar ally</a>, except you may call a single creature of 12 HD or less, or two creatures of the same kind whose HD total no more than 12. The creatures agree to help you and request your return payment together."
        )->setCastingTime("")->setComponents("offerings worth 1,250 gp plus payment")->setRange("")->setTargets(
                ""
            )->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Planar Ally, Greater")->setLongDescription(
            "This spell functions like <a href=\"Planar Ally, Lesser\">lesser planar ally</a>, except that you may call a single creature of 18 HD or less, or up to three creatures of the same kind whose Hit Dice total no more than 18. The creatures agree to help you and request your return payment together."
        )->setCastingTime("")->setComponents("offerings worth 2,500 gp plus payment")->setRange("")->setTargets(
                ""
            )->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Planar Ally, Lesser")->setLongDescription(
            "By casting this spell, you request your deity to send you an outsider (of 6 HD or less) of the deity's choice. If you serve no particular deity, the spell is a general plea answered by a creature sharing your philosophical alignment. If you know an individual creature's name, you may request that individual by speaking the name during the spell (though you might get a different creature anyway). You may ask the creature to perform one task in exchange for a payment from you. Tasks might range from the simple to the complex. You must be able to communicate with the creature called in order to bargain for its services. The creature called requires a payment for its services. This payment can take a variety of forms, from donating gold or magic items to an allied temple, to a gift given directly to the creature, to some other action on your part that matches the creature's alignment and goals. Regardless, this payment must be made before the creature agrees to perform any services. The bargaining takes at least 1 round, so any actions by the creature begin in the round after it arrives. A task taking up to 1 minute per caster level requires a payment of 100 gp per HD of the creature called. For a task taking up to 1 hour per caster level, the creature requires a payment of 500 gp per HD. A long-term task, one requiring up to 1 day per caster level, requires a payment of 1,000 gp per HD. A nonhazardous task requires only half the indicated payment, while an especially hazardous task might require a greater gift. Few if any creatures will accept a task that seems suicidal (remember, a called creature actually dies when it is killed, unlike a summoned creature). However, if the task is strongly aligned with the creature's ethos, it may halve or even waive the payment.  At the end of its task, or when the duration bargained for expires, the creature returns to its home plane (after reporting back to you, if appropriate and possible). Note: When you use a calling spell that calls an air, chaotic, earth, evil, fire, good, lawful, or water creature, it is a spell of that type."
        )->setCastingTime("10 minutes")->setComponents("offerings worth 500 gp plus payment, see text")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Planar Binding")->setLongDescription(
            "This spell functions like <a href=\"Planar Binding, Lesser\">lesser planar binding</a>, except that you may call a single creature of 12 HD or less, or up to three creatures of the same kind whose Hit Dice total no more than 12. Each creature gets a saving throw, makes an independent attempt to escape, and must be individually persuaded to aid you."
        )->setCastingTime("")->setComponents("")->setRange("")->setTargets(
                "up to three elementals or outsiders, totaling no more than 12 HD, no two of which can be more than 30 ft. apart when they appear"
            )->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Planar Binding, Greater")->setLongDescription(
            "This spell functions like <a href=\"Planar Binding, Lesser\">lesser planar binding</a>, except that you may call a single creature of 18 HD or less, or up to three creatures of the same kind whose Hit Dice total no more than 18. Each creature gets a saving throw, makes an independent attempt to escape, and must be individually persuaded to aid you."
        )->setCastingTime("")->setComponents("")->setRange("")->setTargets(
                "up to three elementals or outsiders, totaling no more than 18 HD, no two of which can be more than 30 ft. apart when they appear."
            )->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Planar Binding, Lesser")->setLongDescription(
            "Casting this spell attempts a dangerous act: to lure a creature from another plane to a specifically prepared trap, which must lie within the spell's range. The called creature is held in the trap until it agrees to perform one service in return for its freedom. To create the trap, you must use a magic circle spell, focused inward. The kind of creature to be bound must be known and stated. If you wish to call a specific individual, you must use that individual's proper name in casting the spell. The target creature is allowed a Will saving throw. If the saving throw succeeds, the creature resists the spell. If the saving throw fails, the creature is immediately drawn to the trap (spell resistance does not keep it from being called). The creature can escape from the trap by successfully pitting its spell resistance against your caster level check, by dimensional travel, or with a successful Charisma check (DC 15 + 1/2 your caster level + your Charisma modifier). It can try each method once per day. If it breaks loose, it can flee or attack you. A <a href=\"Dimensional Anchor\">dimensional anchor</a> cast on the creature prevents its escape via dimensional travel. You can also employ a calling diagram (see magic circle against evil) to make the trap more secure. If the creature does not break free of the trap, you can keep it bound for as long as you dare. You can attempt to compel the creature to perform a service by describing the service and perhaps offering some sort of reward. You make a Charisma check opposed by the creature's Charisma check. The check is assigned a bonus of +0 to +6 based on the nature of the service and the reward. If the creature wins the opposed check, it refuses service. New offers, bribes, and the like can be made or the old ones reoffered every 24 hours. This process can be repeated until the creature promises to serve, until it breaks free, or until you decide to get rid of it by means of some other spell. Impossible demands or unreasonable commands are never agreed to. If you ever roll a natural 1 on the Charisma check, the creature breaks free of the spell's effect and can escape or attack you. Once the requested service is completed, the creature need only to inform you to be instantly sent back whence it came. The creature might later seek revenge. If you assign some open-ended task that the creature cannot complete through its own actions, the spell remains in effect for a maximum of 1 day per caster level, and the creature gains an immediate chance to break free (with the same chance to resist as when it was trapped). Note that a clever recipient can subvert some instructions. When you use a calling spell to call an air, chaotic, earth, evil, fire, good, lawful, or water creature, it is a spell of that type. "
        )->setCastingTime("10 minutes")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels); see text"
            )->setTargets("one elemental or outsider with 6 HD or less")->setDuration("instantaneous")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Plane Shift")->setLongDescription(
            "You move yourself or some other creature to another plane of existence or alternate dimension. If several willing persons link hands in a circle, as many as eight can be affected by the plane shift at the same time. Precise accuracy as to a particular arrival location on the intended plane is nigh impossible. From the Material Plane, you can reach any other plane, though you appear 5 to 500 miles (5d%) from your intended destination. Plane shift transports creatures instantaneously and then ends. The creatures need to find other means if they are to travel back (including casting plane shift again)."
        )->setCastingTime("1 standard action")->setComponents(
                "a forked metal rod attuned to the plane of travel"
            )->setRange("touch")->setTargets(
                "creature touched, or up to eight willing creatures joining hands"
            )->setDuration("instantaneous")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Plant Growth")->setLongDescription(
            "Plant growth has different effects depending on the version chosen. Overgrowth: This effect causes normal vegetation (grasses, briars, bushes, creepers, thistles, trees, vines, and so on) within long range (400 feet + 40 feet per caster level) to become thick and overgrown. The plants entwine to form a thicket or jungle that creatures must hack or force a way through. Speed drops to 5 feet, or 10 feet for Large or larger creatures. The area must have brush and trees in it for this spell to take effect. If this spell is cast on an area that is already affected by any spell or effect that enhances plants, such as <a href=\"Entangle\">entangle</a> or <a href=\"Wall of Thorns\">wall of thorns</a>, any DC involved with these spells is increased by 4. This bonus is granted for 1 day after the casting of plant growth. At your option, the area can be a 100-foot-radius circle, a 150-foot-radius semicircle, or a 200-foot-radius quarter circle. You may designate places within the area that are not affected. Enrichment: This effect targets plants within a range of a half-mile, raising their potential productivity over the course of the next year to one-third above normal. Plant growth counters <a href=\"Diminish Plants\">diminish plants</a>. This spell has no effect on plant creatures."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets(
                "see text"
            )->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Plant Shape I")->setLongDescription(
            "When you cast this spell you can assume the form of any Small or Medium creature of the plant type. If the form you assume has any of the following abilities, you gain the listed ability: darkvision 60 feet, low-light vision, constrict, grab, and poison. If the form you assume does not possess the ability to move, your speed is reduced to 5 feet and you lose all other forms of movement. If the creature has vulnerability to an element, you gain that vulnerability. Small plant: If the form you take is that of a Small plant, you gain a +2 size bonus to your Constitution and a +2 natural armor bonus. Medium plant: If the form you take is that of a Medium plant, you gain a +2 size bonus to your Strength, a +2 enhancement bonus to your Constitution, and a +2 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Plant Shape II")->setLongDescription(
            "This spell functions as <a href=\"Plant Shape I\">plant shape I</a> except that it also allows you to assume the form of a Large creature of the plant type. If the creature has immunity or resistance to any elements, you gain resistance 20 to those elements. If the creature has vulnerability to an element, you gain that vulnerability. Large plant: If the form you take is that of a Large plant, you gain a +4 size bonus to your Strength, a +2 size bonus to your Constitution, and a +4 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Plant Shape III")->setLongDescription(
            "This spell functions as <a href=\"Plant Shape II\">plant shape II</a> except that it also allows you to assume the form of a Huge creature of the plant type. If the form you assume has any of the following abilities, you gain the listed ability: DR, regeneration 5, and trample.  Huge plant: If the form you take is that of a Huge plant, you gain a +8 size bonus to your Strength, a -2 penalty to your Dexterity, a +4 size bonus to your Constitution, and a +6 natural armor bonus."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you plan to assume"
            )->setRange("personal")->setTargets("you")->setDuration("1 min./level (D)")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Poison")->setLongDescription(
            "Calling upon the venomous powers of natural predators, you infect the subject with a horrible poison by making a successful melee touch attack. This poison deals 1d3 Constitution damage per round for 6 rounds. Poisoned creatures can make a Fortitude save each round to negate the damage and end the affliction."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("instantaneous; see text")->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Polar Ray")->setLongDescription(
            "A blue-white ray of freezing air and ice springs from your hand. You must succeed on a ranged touch attack with the ray to deal damage to a target. The ray deals 1d6 points of cold damage per caster level (maximum 25d6) and 1d4 points of Dexterity drain."
        )->setCastingTime("1 standard action")->setComponents("a white ceramic cone or prism")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Polymorph")->setLongDescription(
            "This spell transforms a willing creature into an animal, humanoid or elemental of your choosing; the spell has no effect on unwilling creatures, nor can the creature being targeted by this spell influence the new form assumed (apart from conveying its wishes, if any, to you verbally). If you use this spell to cause the target to take on the form of an animal or magical beast, the spell functions as <a href=\"Beast Shape II\">beast shape II</a>. If the form is that of an elemental, the spell functions as <a href=\"Elemental Body I\">elemental body I</a>. If the form is that of a humanoid, the spell functions as <a href=\"Alter Self\">alter self</a>. The subject may choose to resume its normal form as a full-round action; doing so ends the spell for that subject."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you choose"
            )->setRange("touch")->setTargets("living creature touched")->setDuration("1 min/level (D)")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Polymorph, Greater")->setLongDescription(
            "This spell functions as <a href=\"Polymorph\">polymorph</a> except that it allows the creature to take on the form of a dragon or plant creature. If you use this spell to cause the target to take on the form of an animal or magical beast, it functions as <a href=\"Beast Shape IV\">beast shape IV</a>. If the form is that of an elemental, the spell functions as <a href=\"Elemental Body III\">elemental body III</a>. If the form is that of a humanoid, the spell functions as <a href=\"Alter Self\">alter self</a>. If the form is that of a plant, the spell functions as <a href=\"Plant Shape II\">plant shape II</a>. If the form is that of a dragon, the spell functions as <a href=\"Form of the Dragon I\">form of the dragon I</a>. The subject may choose to resume its normal form as a full-round action; doing so ends the spell."
        )->setCastingTime("1 standard action")->setComponents(
                "a piece of the creature whose form you choose"
            )->setRange("touch")->setTargets("living creature touched")->setDuration("1 min/level (D)")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Polymorph Any Object")->setLongDescription(
            "This spell functions like <a href=\"Polymorph, Greater\">greater polymorph</a>, except that it changes one object or creature into another. You can use this spell to transform all manner of objects and creatures into new forms--you aren't limited to transforming a living creature into another living form. The duration of the spell depends on how radical a change is made from the original state to its transmuted state. The duration is determined by using the following guidelines. <table><tr><th>Changed Subject Is...</th><th>Increase to Duration Factor*</th></tr><tr><td>Same kingdom (animal, vegetable, mineral)</td><td>+5</td></tr><tr class=\"alt\"><td>Same class (mammals, fungi, metals, etc.)</td><td>+2</td></tr><tr><td>Same size</td><td>+2</td></tr><tr class=\"alt\"><td>Related (twig is to tree, wolf fur is to wolf, etc.)</td><td>+2</td></tr><tr><td>Same or lower Intelligence</td><td>+2</td></tr></table><i>*Add all that apply. Look up the total on the next table.</i> <table><tr><th>Duration Factor</th><th>Duration</th><th>Example</th></tr><tr><td>0</td><td>20 minutes</td><td>Pebble to human</td></tr><tr class=\"alt\"><td>2</td><td>1 hour</td><td>Marionette to human</td></tr><tr><td>4</td><td>3 hours</td><td>Human to marionette</td></tr><tr class=\"alt\"><td>5</td><td>12 hours</td><td>Lizard to manticore</td></tr><tr><td>6</td><td>2 days</td><td>Sheep to wool coat</td></tr><tr class=\"alt\"><td>7</td><td>1 week</td><td>Shrew to manticore</td></tr><tr><td>9+</td><td>Permanent</td><td>Manticore to shrew</td></tr></table> If the target of the spell does not have physical ability scores (Strength, Dexterity, or Constitution), this spell grants a base score of 10 to each missing ability score. If the target of the spell does not have mental ability scores (Intelligence, Wisdom, or Charisma), this spell grants a score of 5 to such scores. Damage taken by the new form can result in the injury or death of the polymorphed creature. In general, damage occurs when the new form is changed through physical force. A nonmagical object cannot be made into a magic item with this spell. Magic items aren't affected by this spell. This spell cannot create material of great intrinsic value, such as copper, silver, gems, silk, gold, platinum, mithral, or adamantine. It also cannot reproduce the special properties of cold iron in order to overcome the damage reduction of certain creatures. This spell can also be used to duplicate the effects of <a href=\"Baleful Polymorph\">baleful polymorph</a>, <a href=\"Polymorph, Greater\">greater polymorph</a>, <a href=\"Flesh to Stone\">flesh to stone</a>, <a href=\"Stone to Flesh\">stone to flesh</a>, <a href=\"Transmute Mud to Rock\">transmute mud to rock</a>, <a href=\"Transmute Metal to Wood\">transmute metal to wood</a>, or <a href=\"Transmute Rock to Mud\">transmute rock to mud</a>."
        )->setCastingTime("1 standard action")->setComponents("mercury, gum arabic, and smoke")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature, or one nonmagical object of up to 100 cu. ft./level")->setDuration(
                "see text"
            )->setSavingThrow("Fortitude negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Power Word Blind")->setLongDescription(
            "You utter a single word of power that causes a creature to become blinded, whether the creature can hear the word or not. The duration of the spell depends on the target's current hit point total. Any creature that currently has 201 or more hit points is unaffected. <table><tr><th>Hit Points</th><th>Duration</th></tr><tr><td>50 or less</td><td>Permanent</td></tr><tr class=\"alt\"><td>51-100</td><td>1d4+1 minutes</td></tr><tr><td>101-200</td><td>1d4+1 rounds</td></tr></table>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature with 200 hp or less")->setDuration("see text")->setSavingThrow(
                "none"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Power Word Kill")->setLongDescription(
            "You utter a single word of power that instantly kills one creature of your choice, whether the creature can hear the word or not. Any creature that currently has 101 or more hit points is unaffected by power word kill."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature with 100 hp or less")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Power Word Stun")->setLongDescription(
            "You utter a single word of power that instantly causes one creature of your choice to become stunned, whether the creature can hear the word or not. The duration of the spell depends on the target's current hit point total. Any creature that currently has 151 or more hit points is unaffected by power word stun. Hit Points	Duration: 50 or less	4d4 rounds, 51-100	2d4 rounds, 101-150	1d4 rounds	"
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature with 150 hp or less")->setDuration("See text")->setSavingThrow(
                "none"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prayer")->setLongDescription(
            "You bring special favor upon yourself and your allies while bringing disfavor to your enemies. You and each of your allies gain a +1 luck bonus on attack rolls, weapon damage rolls, saves, and skill checks, while each of your foes takes a -1 penalty on such rolls."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("40 ft.")->setTargets("")->setDuration(
                "1 round/level"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prestidigitation")->setLongDescription(
            "Prestidigitations are minor tricks that novice spellcasters use for practice. Once cast, a prestidigitation spell enables you to perform simple magical effects for 1 hour. The effects are minor and have severe limitations. A prestidigitation can slowly lift 1 pound of material. It can color, clean, or soil items in a 1-foot cube each round. It can chill, warm, or flavor 1 pound of nonliving material. It cannot deal damage or affect the concentration of spellcasters. Prestidigitation can create small objects, but they look crude and artificial. The materials created by a prestidigitation spell are extremely fragile, and they cannot be used as tools, weapons, or spell components. Finally, prestidigitation lacks the power to duplicate any other spell effects. Any actual change to an object (beyond just moving, cleaning, or soiling it) persists only 1 hour."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("10 ft.")->setTargets(
                "see text"
            )->setDuration("1 hour")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prismatic Sphere")->setLongDescription(
            "This spell functions like <a href=\"Prismatic Wall\">prismatic wall</a>, except you conjure up an immobile, opaque globe of shimmering, multicolored light that surrounds you and protects you from all forms of attack. The sphere flashes in all colors of the visible spectrum.  The sphere's blindness effect on creatures with less than 8 HD lasts 2d4 x 10 minutes. You can pass into and out of the prismatic sphere and remain near it without harm. When you're inside it, however, the sphere blocks any attempt to project something through the sphere (including spells). Other creatures that attempt to attack you or pass through suffer the effects of each color, one at a time. Typically, only the upper hemisphere of the globe exists, since you are at the center of the sphere, so the lower half is usually occluded by the floor surface you are standing on. The colors of the sphere have the same effects as the colors of a <a href=\"Prismatic Wall\">prismatic wall</a>. Prismatic sphere can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("")->setComponents("")->setRange("10 ft.")->setTargets("")->setDuration("")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prismatic Spray")->setLongDescription(
            "This spell causes seven shimmering, multicolored beams of light to spray from your hand. Each beam has a different power. Creatures in the area of the spell with 8 HD or less are automatically blinded for 2d4 rounds. Every creature in the area is randomly struck by one or more beams, which have additional effects. <table><tr><th>1d8</th><th>Color of Beam</th><th></th></tr><tr><td>1</td><td>Red</td><td>20 points fire damage (Reflex half)</td></tr><tr class=\"alt\"><td>2</td><td>Orange</td><td>40 points acid damage (Reflex half)</td></tr><tr><td>3</td><td>Yellow</td><td>80 points electricity damage (Reflex half)</td></tr><tr class=\"alt\"><td>4</td><td>Green</td><td>Poison (Frequency 1/rd. for 6 rd.; Init. effect death; Sec. effect 1 Con/rd.; Cure 2 consecutive Fort saves)*</td></tr><tr><td>5</td><td>Blue</td><td>Flesh to stone (Fortitude negates)</td></tr><tr class=\"alt\"><td>6</td><td>Indigo</td><td>Insane, as <a href=\"Insanity\">insanity</a> spell (Will negates)</td></tr><tr><td>7</td><td>Violet</td><td>Sent to another plane (Will negates)</td></tr><tr class=\"alt\"><td>8</td><td>Struck by two rays</td><td>Roll twice more, ignoring any 8 results</td></tr></table><i>* See poisons.</i>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prismatic Wall")->setLongDescription(
            "Prismatic wall creates a vertical, opaque wall--a shimmering, multicolored plane of light that protects you from all forms of attack. The wall flashes with seven colors, each of which has a distinct power and purpose. The wall is immobile, and you can pass through and remain near the wall without harm. Any other creature with less than 8 HD that is within 20 feet of the wall is blinded by the colors for 2d4 rounds if it looks at the wall. The wall's maximum proportions are 4 feet wide per caster level and 2 feet high per caster level. A prismatic wall spell cast to materialize in a space occupied by a creature is disrupted, and the spell is wasted. Each color in the wall has a special effect. The accompanying table shows the seven colors of the wall, the order in which they appear, their effects on creatures trying to attack you or pass through the wall, and the magic needed to negate each color. The wall can be destroyed, color by color, in consecutive order, by casting the specified spells on the wall; however, the first color must be brought down before the second can be affected, and so on. A rod of cancellation or a <a href=\"Mage's Disjunction\">mage's disjunction</a> spell destroys a prismatic wall, but an <a href=\"Antimagic Field\">antimagic field</a> fails to penetrate it. <a href=\"Dispel Magic\">Dispel magic</a> and <a href=\"Dispel Magic, Greater\">greater dispel magic</a> can only be used on the wall once all the other colors have been destroyed. Spell resistance is effective against a prismatic wall, but the caster level check must be repeated for each color present. Prismatic wall can be made permanent with a <a href=\"Permanency\">permanency</a> spell. <table><tr><th>Order</th><th>Color</th><th>Effect of Color</th><th>Negated by</th></tr><tr><td>1st</td><td>Red</td><td>Stops nonmagical ranged weapons.<br/>Deals 20 points of fire damage (Reflex half).</td><td>Cone of cold</td></tr><tr class=\"alt\"><td>2nd</td><td>Orange</td><td>Stops magical ranged weapons.<br/>Deals 40 points of acid damage (Reflex half).</td><td>Gust of wind</td></tr><tr><td>3rd</td><td>Yellow</td><td>Stops poisons, gases, and petrification.<br/>Deals 80 points of electricity damage (Reflex half).</td><td>Disintegrate</td></tr><tr class=\"alt\"><td>4th</td><td>Green</td><td>Stops breath weapons.<br/>Poison (frequency: 1/rd. for 6 rd.; init. effect: death, sec. effect: 1 Con/rd.; cure 2 consecutive Fort saves).</td><td>Passwall</td></tr><tr><td>5th</td><td>Blue</td><td>Stops divination and mental attacks.<br/>Turned to stone (Fortitude negates).</td><td>Magic missile</td></tr><tr class=\"alt\"><td>6th</td><td>Indigo</td><td>Stops all spells.<br/>Will save or become insane (as <a href=\"Insanity\">insanity</a> spell).</td><td>Daylight</td></tr><tr><td>7th</td><td>Violet</td><td>Energy field destroys all objects and effects.*<br/>Creatures sent to another plane (Will negates).</td><td><a href=\"Dispel Magic\">Dispel magic</a> or<a href=\"Dispel Magic, Greater\">greater dispel magic</a></td></tr></table><i>* The violet effect makes the special effects of the other six colors redundant, but these six effects are included here because certain magic items can create prismatic effects one color at a time, and spell resistance might render some colors ineffective (see above).</i>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("10 min./level (D)")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Produce Flame")->setLongDescription(
            "Flames as bright as a torch appear in your open hand. The flames harm neither you nor your equipment. In addition to providing illumination, the flames can be hurled or used to touch enemies. You can strike an opponent with a melee touch attack, dealing fire damage equal to 1d6 + 1 point per caster level (maximum +5). Alternatively, you can hurl the flames up to 120 feet as a thrown weapon. When doing so, you attack with a ranged touch attack (with no range penalty) and deal the same damage as with the melee attack. No sooner do you hurl the flames than a new set appears in your hand. Each attack you make reduces the remaining duration by 1 minute. If an attack reduces the remaining duration to 0 minutes or less, the spell ends after the attack resolves. This spell does not function underwater."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("0 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Programmed Image")->setLongDescription(
            "This spell functions like <a href=\"Silent Image\">silent image</a>, except that this spell's figment activates when a specific condition occurs. The figment includes visual, auditory, olfactory, and thermal elements, including intelligible speech. You set the triggering condition (which may be a special word) when casting the spell. The event that triggers the illusion can be as general or as specific and detailed as desired but must be based on an audible, tactile, olfactory, or visual trigger. The trigger cannot be based on some quality not normally obvious to the senses, such as alignment. See <a href=\"Magic Mouth\">magic mouth</a> for more details about such triggers."
        )->setCastingTime("")->setComponents("fleece and jade dust worth 25 gp")->setRange("")->setTargets(
                ""
            )->setDuration("permanent until triggered, then 1 round/level")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Project Image")->setLongDescription(
            "You tap energy from the Plane of Shadow to create a quasi-real, illusory version of yourself. The projected image looks, sounds, and smells like you but is intangible. The projected image mimics your actions (including speech) unless you direct it to act differently (which is a move action). You can see through its eyes and hear through its ears as if you were standing where it is, and during your turn you can switch from using its senses to using your own, or back again, as a free action. While you are using its senses, your body is considered blinded and deafened. If you desire, any spell you cast whose range is touch or greater can originate from the projected image instead of from you. The projected image can't cast any spells on itself except for illusion spells. The spells affect other targets normally, despite originating from the projected image. Objects are affected by the projected image as if they had succeeded on their Will save. You must maintain line of effect to the projected image at all times. If your line of effect is obstructed, the spell ends. If you use <a href=\"Dimension Door\">dimension door</a>, <a href=\"Teleport\">teleport</a>, <a href=\"Plane Shift\">plane shift</a>, or a similar spell that breaks your line of effect, even momentarily, the spell ends."
        )->setCastingTime("1 standard action")->setComponents("a small replica of you worth 5 gp")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Arrows")->setLongDescription(
            "The warded creature gains resistance to ranged weapons. The subject gains damage reduction 10/magic against ranged weapons. This spell doesn't grant you the ability to damage creatures with similar damage reduction. Once the spell has prevented a total of 10 points of damage per caster level (maximum 100 points), it is discharged."
        )->setCastingTime("1 standard action")->setComponents("a piece of tortoiseshell or turtle shell")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 hour/level or until discharged")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Chaos")->setLongDescription(
            "This spell functions like <a href=\"Protection from Evil\">protection from evil</a>, except that the deflection and resistance bonuses apply to attacks made by chaotic creatures. The target receives a new saving throw against control by chaotic creatures and chaotic summoned creatures cannot touch the target."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Energy")->setLongDescription(
            "Protection from energy grants temporary immunity to the type of energy you specify when you cast it (acid, cold, electricity, fire, or sonic). When the spell absorbs 12 points per caster level of energy damage (to a maximum of 120 points at 10th level), it is discharged. Protection from energy overlaps (and does not stack with) <a href=\"Resist Energy\">resist energy</a>. If a character is warded by protection from energy and <a href=\"Resist Energy\">resist energy</a>, the protection spell absorbs damage until its power is exhausted."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("10 min./level or until discharged")->setSavingThrow(
                "Fortitude negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Evil")->setLongDescription(
            "This spell wards a creature from attacks by evil creatures, from mental control, and from summoned creatures. It creates a magical barrier around the subject at a distance of 1 foot. The barrier moves with the subject and has three major effects. First, the subject gains a +2 deflection bonus to AC and a +2 resistance bonus on saves. Both these bonuses apply against attacks made or effects created by evil creatures. Second, the subject immediately receives another saving throw (if one was allowed to begin with) against any spells or effects that possess or exercise mental control over the creature (including enchantment [charm] effects and enchantment [compulsion] effects). This saving throw is made with a +2 morale bonus, using the same DC as the original effect. If successful, such effects are suppressed for the duration of this spell. The effects resume when the duration of this spell expires. While under the effects of this spell, the target is immune to any new attempts to possess or exercise mental control over the target. This spell does not expel a controlling life force (such as a ghost or spellcaster using magic jar), but it does prevent them from controlling the target. This second effect only functions against spells and effects created by evil creatures or objects, subject to GM discretion. Third, the spell prevents bodily contact by evil summoned creatures. This causes the natural weapon attacks of such creatures to fail and the creatures to recoil if such attacks require touching the warded creature. Summoned creatures that are not evil are immune to this effect. The protection against contact by summoned creatures ends if the warded creature makes an attack against or tries to force the barrier against the blocked creature. Spell resistance can allow a creature to overcome this protection and touch the warded creature."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Good")->setLongDescription(
            "This spell functions like <a href=\"Protection from Evil\">protection from evil</a>, except that the deflection and resistance bonuses apply to attacks made by good creatures. The target receives a new saving throw against control by good creatures and good summoned creatures cannot touch the target."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Law")->setLongDescription(
            "This spell functions like <a href=\"Protection from Evil\">protection from evil</a>, except that the deflection and resistance bonuses apply to attacks made by lawful creatures. The target receives a new saving throw against control by lawful creatures and lawful summoned creatures cannot touch the target."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Protection from Spells")->setLongDescription(
            "The subject gains a +8 resistance bonus on saving throws against spells and spell-like abilities (but not against supernatural and extraordinary abilities)."
        )->setCastingTime("1 standard action")->setComponents(
                "diamond worth 500 gp & One 1,000 gp diamond per target. Each subject must carry the gem for the duration of the spell. If a subject loses the gem, the spell ceases to affect him."
            )->setRange("touch")->setTargets("up to one creature touched per four levels")->setDuration(
                "10 min./level"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prying Eyes")->setLongDescription(
            "You create a number of semitangible, visible magical orbs (called eyes) equal to 1d4 + your caster level. These eyes move out, scout around, and return as you direct them when casting the spell. Each eye can see 120 feet (normal vision only) in all directions. While the individual eyes are quite fragile, they're small and difficult to spot. Each eye is a Fine construct, about the size of a small apple, that has 1 hit point, AC 18 (+8 bonus for its size), flies at a speed of 30 feet with a +20 bonus on Fly skill checks and a +16 bonus on Stealth skill checks. It has a Perception modifier equal to your caster level (maximum +15) and is subject to illusions, darkness, fog, and any other factors that affect your ability to receive visual information about your surroundings. An eye traveling in darkness must find its way by touch. When you create the eyes, you specify instructions you want them to follow in a command of no more than 25 words. Any knowledge you possess is known by the eyes as well. In order to report their findings, the eyes must return to your hand. Each replays in your mind all it has seen during its existence. It takes an eye 1 round to replay 1 hour of recorded images. After relaying its findings, an eye disappears.  If an eye ever gets more than 1 mile away from you, it instantly ceases to exist. However, your link with the eye is such that you won't know if the eye was destroyed because it wandered out of range or because of some other event. The eyes exist for up to 1 hour per caster level or until they return to you. <a href=\"Dispel Magic\">Dispel magic</a> can destroy eyes. Roll separately for each eye caught in an area dispel. Of course, if an eye is sent into darkness, it could hit a wall or similar obstacle and destroy itself."
        )->setCastingTime("1 minute")->setComponents("a handful of crystal marbles")->setRange("1 mile")->setTargets(
                ""
            )->setDuration("1 hour/level; see text (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Prying Eyes, Greater")->setLongDescription(
            "This spell functions like <a href=\"Prying Eyes\">prying eyes</a>, except that the eyes can see all things as they actually are, just as if they had true seeing with a range of 120 feet. Thus, they can navigate darkened areas at normal speed. Also, a greater prying eye's maximum Perception modifier is +25 instead of +15."
        )->setCastingTime("1 minute")->setComponents("a handful of crystal marbles")->setRange("1 mile")->setTargets(
                ""
            )->setDuration("1 hour/level; see text (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Purify Food and Drink")->setLongDescription(
            "This spell makes spoiled, rotten, diseased, poisonous, or otherwise contaminated food and water pure and suitable for eating and drinking. This spell does not prevent subsequent natural decay or spoilage. Unholy water and similar food and drink of significance is spoiled by purify food and drink, but the spell has no effect on creatures of any type nor upon magic potions. Water weighs about 8 pounds per gallon. One cubic foot of water contains roughly 8 gallons and weighs about 60 pounds."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("10 ft.")->setTargets(
                "1 cu. ft./level of contaminated food and water"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Pyrotechnics")->setLongDescription(
            "Pyrotechnics turns a fire into a burst of blinding fireworks or a thick cloud of choking smoke, depending on your choice. The spell uses one fire source, which is immediately extinguished. A fire so large that it exceeds a 20-foot cube is only partly extinguished. Magical fires are not extinguished, although a fire-based creature used as a source takes 1 point of damage per caster level. Fireworks: The fireworks are a flashing, fiery, momentary burst of glowing, colored aerial lights. This effect causes creatures within 120 feet of the fire source to become blinded for 1d4+1 rounds (Will negates). These creatures must have line of sight to the fire to be affected. Spell resistance can prevent blindness. Smoke Cloud: A stream of smoke billows out from the fire, forming a choking cloud that spreads 20 feet in all directions and lasts for 1 round per caster level. All sight, even darkvision, is ineffective in or through the cloud. All within the cloud take -4 penalties to Strength and Dexterity (Fortitude negates). These effects last for 1d4+1 rounds after the cloud dissipates or after the creature leaves the area of the cloud. Spell resistance does not apply."
        )->setCastingTime("1 standard action")->setComponents("one fire source")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("one fire source, up to a 20-ft. cube")->setDuration(
                "1d4+1 rounds, or 1d4+1 rounds after creatures leave the smoke cloud; see text"
            )->setSavingThrow("Will negates or Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Quench")->setLongDescription(
            "Quench is often used to put out forest fires and other conflagrations. It extinguishes all nonmagical fires in its area. The spell also dispels any fire spells in its area, though you must succeed on a dispel check (1d20 +1 per caster level, maximum +15) against each spell to dispel it. The DC to dispel such spells is 11 + the caster level of the fire spell. Each creature with the fire subtype within the area of a quench spell takes 1d6 points of damage per caster level (maximum 10d6, no save allowed). Alternatively, you can target the spell on a single magic item that creates or controls flame. The item loses all its fire-based magical abilities for 1d4 hours unless it succeeds on a Will save. Artifacts are immune to this effect."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one fire-based magic item")->setDuration("instantaneous")->setSavingThrow(
                "none or Will negates (object)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Rage")->setLongDescription(
            "Each affected creature gains a +2 morale bonus to Strength and Constitution, a +1 morale bonus on Will saves, and a -2 penalty to AC. The effect is otherwise identical with a barbarian's rage except that the subjects aren't fatigued at the end of the rage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets(
                "one willing living creature per three levels, no two of which may be more than 30 ft. apart"
            )->setDuration("concentration + 1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Rainbow Pattern")->setLongDescription(
            "A glowing, rainbow-hued pattern of interweaving colors fascinates those within it. Rainbow pattern fascinates a maximum of 24 HD of creatures. Creatures with the fewest HD are affected first. Among creatures with equal HD, those who are closest to the spell's point of origin are affected first. An affected creature that fails its saves is fascinated by the pattern. With a simple gesture (a free action), you can make the rainbow pattern move up to 30 feet per round (moving its effective point of origin). All fascinated creatures follow the moving rainbow of light, trying to remain within the effect. Fascinated creatures who are restrained and removed from the pattern still try to follow it. If the pattern leads its subjects into a dangerous area, each fascinated creature gets a second save. If the view of the lights is completely blocked, creatures who can't see them are no longer affected. The spell does not affect sightless creatures."
        )->setCastingTime("1 standard action")->setComponents(
                "bard only & a piece of phosphor & a crystal prism"
            )->setRange("medium (100 ft. + 10 ft./level)")->setTargets("")->setDuration(
                "Concentration +1 round/level (D)"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Raise Dead")->setLongDescription(
            "You restore life to a deceased creature. You can raise a creature that has been dead for no longer than 1 day per caster level. In addition, the subject's soul must be free and willing to return. If the subject's soul is not willing to return, the spell does not work; therefore, a subject that wants to return receives no saving throw. Coming back from the dead is an ordeal. The subject of the spell gains two permanent negative levels when it is raised, just as if it had been hit by an energy-draining creature. If the subject is 1st level, it takes 2 points of Constitution drain instead (if this would reduce its Con to 0 or less, it can't be raised). A character who died with spells prepared has a 50% chance of losing any given spell upon being raised. A spellcasting creature that doesn't prepare spells (such as a sorcerer) has a 50% chance of losing any given unused spell slot as if it had been used to cast a spell. A raised creature has a number of hit points equal to its current HD. Any ability scores damaged to 0 are raised to 1. Normal poison and normal disease are cured in the process of raising the subject, but magical diseases and curses are not undone. While the spell closes mortal wounds and repairs lethal damage of most kinds, the body of the creature to be raised must be whole. Otherwise, missing parts are still missing when the creature is brought back to life. None of the dead creature's equipment or possessions are affected in any way by this spell. A creature who has been turned into an undead creature or killed by a death effect can't be raised by this spell. Constructs, elementals, outsiders, and undead creatures can't be raised. The spell cannot bring back a creature that has died of old age."
        )->setCastingTime("1 minute")->setComponents("diamond worth 5,000 gp")->setRange("touch")->setTargets(
                "dead creature touched"
            )->setDuration("instantaneous")->setSavingThrow("none, see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ray of Enfeeblement")->setLongDescription(
            "A coruscating ray springs from your hand. You must succeed on a ranged touch attack to strike a target. The subject takes a penalty to Strength equal to 1d6+1 per two caster levels (maximum 1d6+5). The subject's Strength score cannot drop below 1. A successful Fortitude save reduces this penalty by half. This penalty does not stack with itself. Apply the highest penalty instead."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("Fortitude half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ray of Exhaustion")->setLongDescription(
            "A black ray projects from your pointing finger. You must succeed on a ranged touch attack with the ray to strike a target. The subject is immediately exhausted for the spell's duration. A successful Fortitude save means the creature is only fatigued. A character that is already fatigued instead becomes exhausted. This spell has no effect on a creature that is already exhausted. Unlike normal exhaustion or fatigue, the effect ends as soon as the spell's duration expires."
        )->setCastingTime("1 standard action")->setComponents("a drop of sweat")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Fortitude partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ray of Frost")->setLongDescription(
            "A ray of freezing air and ice projects from your pointing finger. You must succeed on a ranged touch attack with the ray to deal damage to a target. The ray deals 1d3 points of cold damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Read Magic")->setLongDescription(
            "You can decipher magical inscriptions on objects--books, scrolls, weapons, and the like--that would otherwise be unintelligible. This deciphering does not normally invoke the magic contained in the writing, although it may do so in the case of a cursed or trapped scroll. Furthermore, once the spell is cast and you have read the magical inscription, you are thereafter able to read that particular writing without recourse to the use of read magic. You can read at the rate of one page (250 words) per minute. The spell allows you to identify a <a href=\"Glyph of Warding\">glyph of warding</a> with a DC 13 Spellcraft check, a <a href=\"Glyph of Warding, Greater\">greater glyph of warding</a> with a DC 16 Spellcraft check, or any symbol spell with a Spellcraft check (DC 10 + spell level). Read magic can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("a clear crystal or mineral prism")->setRange(
                "personal"
            )->setTargets("you")->setDuration("10 min./level")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Reduce Animal")->setLongDescription(
            "This spell functions like <a href=\"Reduce Person\">reduce person</a>, except that it affects a single willing animal. Reduce the damage dealt by the animal's natural attacks as appropriate for its new size (see Equipment how to adjust damage for size)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one willing animal of Small, Medium, Large, or Huge size"
            )->setDuration("1 hour/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Reduce Person")->setLongDescription(
            "This spell causes instant diminution of a humanoid creature, halving its height, length, and width and dividing its weight by 8. This decrease changes the creature's size category to the next smaller one. The target gains a +2 size bonus to Dexterity, a -2 size penalty to Strength (to a minimum of 1), and a +1 bonus on attack rolls and AC due to its reduced size. A Small humanoid creature whose size decreases to Tiny has a space of 2-1/2 feet and a natural reach of 0 feet (meaning that it must enter an opponent's square to attack). A Large humanoid creature whose size decreases to Medium has a space of 5 feet and a natural reach of 5 feet. This spell doesn't change the target's speed. All equipment worn or carried by a creature is similarly reduced by the spell. Melee and projectile weapons deal less damage. Other magical properties are not affected by this spell. Any reduced item that leaves the reduced creature's possession (including a projectile or thrown weapon) instantly returns to its normal size. This means that thrown weapons deal their normal damage (projectiles deal damage based on the size of the weapon that fired them). Multiple magical effects that reduce size do not stack. Reduce person counters and dispels <a href=\"Enlarge Person\">enlarge person</a>. Reduce person can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 round")->setComponents("a pinch of powdered iron")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one humanoid creature")->setDuration("1 min./level (D)")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Reduce Person, Mass")->setLongDescription(
            "This spell functions like <a href=\"Reduce Person\">reduce person</a>, except that it affects multiple creatures."
        )->setCastingTime("1 round")->setComponents("a pinch of powdered iron")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one humanoid creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Refuge")->setLongDescription(
            "When you cast this spell, you create powerful magic in a specially prepared object. This object contains the power to instantly transport its possessor across any distance within the same plane to your abode. Once the item is so enhanced, you must give it willingly to a creature and at the same time inform it of a command word to be spoken when the item is used. To make use of the item, the subject speaks the command word at the same time that it rends or breaks the item (a standard action). When this is done, the individual and all objects it is wearing and carrying (to a maximum of the character's heavy load) are instantly transported to your abode. No other creatures are affected (aside from a familiar or animal companion that is touching the subject). You can alter the spell when casting it so that it transports you to within 10 feet of the possessor of the item when it is broken and the command word spoken. You will have a general idea of the location and situation of the item possessor at the time the refuge spell is discharged, but once you decide to alter the spell in this fashion, you have no choice whether or not to be transported."
        )->setCastingTime("1 standard action")->setComponents("a prepared object worth 1,500 gp")->setRange(
                "touch"
            )->setTargets("object touched")->setDuration("permanent until discharged")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Regenerate")->setLongDescription(
            "The subject's severed body members (fingers, toes, hands, feet, arms, legs, tails, or even heads of multiheaded creatures), broken bones, and ruined organs grow back. After the spell is cast, the physical regeneration is complete in 1 round if the severed members are present and touching the creature. It takes 2d10 rounds otherwise. Regenerate also cures 4d8 points of damage + 1 point per caster level (maximum +35), rids the subject of exhaustion and fatigue, and eliminates all nonlethal damage the subject has taken. It has no effect on nonliving creatures (including undead)."
        )->setCastingTime("3 full rounds")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Reincarnate")->setLongDescription(
            "With this spell, you bring back a dead creature in another body, provided that its death occurred no more than 1 week before the casting of the spell and the subject's soul is free and willing to return. If the subject's soul is not willing to return, the spell does not work; therefore, a subject that wants to return receives no saving throw. Since the dead creature is returning in a new body, all physical ills and afflictions are repaired. The condition of the remains is not a factor. So long as some small portion of the creature's body still exists, it can be reincarnated, but the portion receiving the spell must have been part of the creature's body at the time of death. The magic of the spell creates an entirely new young adult body for the soul to inhabit from the natural elements at hand. This process takes 1 hour to complete. When the body is ready, the subject is reincarnated. A reincarnated creature recalls the majority of its former life and form. It retains any class abilities, feats, or skill ranks it formerly possessed. Its class, base attack bonus, base save bonuses, and hit points are unchanged. Strength, Dexterity, and Constitution scores depend partly on the new body. First eliminate the subject's racial adjustments (since it is no longer necessarily of his previous race) and then apply the adjustments found below to its remaining ability scores. The subject of the spell gains two permanent negative levels when it is reincarnated. If the subject is 1st level, it takes 2 points of Constitution drain instead (if this would reduce its Con to 0 or less, it can't be reincarnated). A character who died with spells prepared has a 50% chance of losing any given spell upon being reincarnated. A spellcasting creature that doesn't prepare spells (such as a sorcerer) has a 50% chance of losing any given unused spell slot as if it had been used to cast a spell. It's possible for the change in the subject's ability scores to make it difficult for it to pursue its previous character class. If this is the case, the subject is advised to become a multiclass character. For a humanoid creature, the new incarnation is determined using the table below. For nonhumanoid creatures, a similar table of creatures of the same type should be created. A creature that has been turned into an undead creature or killed by a death effect can't be returned to life by this spell. Constructs, elementals, outsiders, and undead creatures can't be reincarnated. The spell can bring back a creature that has died of old age. <table><tr><th>d100</th><th>Incarnation</th><th>Str</th><th>Dex</th><th>Con</th></tr><tr><td>01</td><td>Bugbear</td><td>+4</td><td>+2</td><td>+2</td></tr><tr class=\"alt\"><td>02-13</td><td>Dwarf</td><td>+0</td><td>+0</td><td>+2</td></tr><tr><td>14-25</td><td>Elf</td><td>+0</td><td>+2</td><td>-2</td></tr><tr class=\"alt\"><td>26</td><td>Gnoll</td><td>+4</td><td>+0</td><td>+2</td></tr><tr><td>27-38</td><td>Gnome</td><td>-2</td><td>+0</td><td>+2</td></tr><tr class=\"alt\"><td>39-42</td><td>Goblin</td><td>-2</td><td>+2</td><td>+0</td></tr><tr><td>43-52</td><td>Half-elf</td><td>+0</td><td>+2</td><td>+0</td></tr><tr class=\"alt\"><td>53-62</td><td>Half-orc</td><td>+2</td><td>+0</td><td>+0</td></tr><tr><td>63-74</td><td>Halfling</td><td>-2</td><td>+2</td><td>+0</td></tr><tr class=\"alt\"><td>75-89</td><td>Human</td><td>+0</td><td>+0</td><td>+2</td></tr><tr><td>90-93</td><td>Kobold</td><td>-4</td><td>+2</td><td>-2</td></tr><tr class=\"alt\"><td>94</td><td>Lizardfolk</td><td>+2</td><td>+0</td><td>+2</td></tr><tr><td>95-98</td><td>Orc</td><td>+4</td><td>+0</td><td>+0</td></tr><tr class=\"alt\"><td>99</td><td>Troglodyte</td><td>+0</td><td>-2</td><td>+4</td></tr><tr><td>100</td><td>Other (GM's choice)</td><td>?</td><td>?</td><td>?</td></tr></table> The reincarnated creature gains all abilities associated with its new form, including forms of movement and speeds, natural armor, natural attacks, extraordinary abilities, and the like, but it doesn't automatically speak the language of the new form.  A <a href=\"Wish\">wish</a> or a <a href=\"Miracle\">miracle</a> spell can restore a reincarnated character to his or her original form."
        )->setCastingTime("10 minutes")->setComponents("oils worth 1,000 gp")->setRange("touch")->setTargets(
                "dead creature touched"
            )->setDuration("instantaneous")->setSavingThrow("none, see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Remove Blindness/Deafness")->setLongDescription(
            "Remove blindness/deafness cures blindness or deafness (your choice), whether the effect is normal or magical in nature. The spell does not restore ears or eyes that have been lost, but it repairs them if they are damaged. Remove blindness/deafness counters and dispels <a href=\"Blindness/Deafness\">blindness/deafness</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Remove Curse")->setLongDescription(
            "Remove curse can remove all curses on an object or a creature. If the target is a creature, you must make a caster level check (1d20 + caster level) against the DC of each curse affecting the target. Success means that the curse is removed. Remove curse does not remove the curse from a cursed shield, weapon, or suit of armor, although a successful caster level check enables the creature afflicted with any such cursed item to remove and get rid of it. Remove curse counters and dispels <a href=\"Bestow Curse\">bestow curse</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature or object touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Remove Disease")->setLongDescription(
            "Remove disease can cure all diseases from which the subject is suffering. You must make a caster level check (1d20 + caster level) against the DC of each disease affecting the target. Success means that the disease is cured. The spell also kills some hazards and parasites, including green slime and others. Since the spell's duration is instantaneous, it does not prevent reinfection after a new exposure to the same disease at a later date."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Remove Fear")->setLongDescription(
            "You instill courage in the subject, granting it a +4 morale bonus against fear effects for 10 minutes. If the subject is under the influence of a fear effect when receiving the spell, that effect is suppressed for the duration of the spell. Remove fear counters and dispels <a href=\"Cause Fear\">cause fear</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "one creature plus one additional creature per four levels, no two of which can be more than 30 ft. apart"
            )->setDuration("10 minutes; see text")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Remove Paralysis")->setLongDescription(
            "You can free one or more creatures from the effects of temporary paralysis or related magic, including spells and effects that cause a creature to gain the staggered condition. If the spell is cast on one creature, the paralysis is negated. If cast on two creatures, each receives another save with a +4 resistance bonus against the effect that afflicts it. If cast on three or four creatures, each receives another save with a +2 resistance bonus. The spell does not restore ability scores reduced by penalties, damage, or drain."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("up to four creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Repel Metal or Stone")->setLongDescription(
            "This spell creates waves of invisible energy that roll forth from you. All metal or stone objects in the path of the spell are pushed away from you to the limit of the range. Fixed metal or stone objects larger than 3 inches in diameter and loose objects weighing more than 500 pounds are not affected. Anything else, including animated objects, small boulders, and creatures in metal armor, moves back. Fixed objects 3 inches in diameter or smaller bend or break, and the pieces move with the wave of energy. Objects affected by the spell are repelled at the rate of 40 feet per round. Objects such as metal armor, swords, and the like are pushed back, dragging their bearers with them. Even magic items with metal components are repelled, although an <a href=\"Antimagic Field\">antimagic field</a> blocks the effects. A creature being dragged by an item it is carrying can let go. A creature being dragged by a shield can loose it as a move action and drop it as a free action. The waves of energy continue to sweep down the set path for the spell's duration. After you cast the spell, the path is set, and you can then do other things or go elsewhere without affecting the spell's power."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Repel Vermin")->setLongDescription(
            "An invisible barrier holds back vermin. A vermin with HD of less than one-third your level cannot penetrate the barrier. A vermin with HD of one-third your level or more can penetrate the barrier if it succeeds on a Will save. Even so, crossing the barrier deals the vermin 2d6 points of damage, and pressing against the barrier causes pain, which deters most vermin."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("10 ft.")->setTargets("")->setDuration(
                "10 min./level (D)"
            )->setSavingThrow("none or Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Repel Wood")->setLongDescription(
            "Waves of energy roll forth from you, moving in the direction that you determine, causing all wooden objects in the path of the spell to be pushed away from you to the limit of the range. Wooden objects larger than 3 inches in diameter that are fixed firmly are not affected, but loose objects are. Objects 3 inches in diameter or smaller that are fixed in place splinter and break, and the pieces move with the wave of energy. Objects affected by the spell are repelled at the rate of 40 feet per round. Objects such as wooden shields, spears, wooden weapon shafts and hafts, and arrows and bolts are pushed back, dragging those carrying them along. A creature being dragged by an item it is carrying can let go. A creature being dragged by a shield can loose it as a move action and drop it as a free action. If a spear is planted (set) in a way that prevents this forced movement, it splinters. Even magic items with wooden sections are repelled, although an <a href=\"Antimagic Field\">antimagic field</a> blocks the effects. The waves of energy continue to sweep down the set path for the spell's duration. After you cast the spell, the path is set, and you can then do other things or go elsewhere without affecting the spell's power."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Repulsion")->setLongDescription(
            "An invisible, mobile field surrounds you and prevents creatures from approaching you. You decide how big the field is at the time of casting (to the limit your level allows). Any creature within or entering the field must attempt a save. If it fails, it becomes unable to move toward you for the duration of the spell. Repelled creatures' actions are not otherwise restricted. They can fight other creatures and can cast spells and attack you with ranged weapons. If you move closer to an affected creature, nothing happens. The creature is not forced back. The creature is free to make melee attacks against you if you come within reach. If a repelled creature moves away from you and then tries to turn back toward you, it cannot move any closer if it is still within the spell's area."
        )->setCastingTime("1 standard action")->setComponents("a pair of canine statuettes worth 50 gp")->setRange(
                "up to 10 ft./level"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Resilient Sphere")->setLongDescription(
            "A globe of shimmering force encloses a creature, provided the creature is small enough to fit within the diameter of the sphere. The sphere contains its subject for the spell's duration. The sphere functions as a <a href=\"Wall of Force\">wall of force</a>, except that it can be negated by <a href=\"Dispel Magic\">dispel magic</a>. A subject inside the sphere can breathe normally. The sphere cannot be physically moved either by people outside it or by the struggles of those within."
        )->setCastingTime("1 standard action")->setComponents("a crystal sphere")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow("Reflex negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Resistance")->setLongDescription(
            "You imbue the subject with magical energy that protects it from harm, granting it a +1 resistance bonus on saves. Resistance can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("a miniature cloak")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 minute")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Resist Energy")->setLongDescription(
            "This abjuration grants a creature limited protection from damage of whichever one of five energy types you select: acid, cold, electricity, fire, or sonic. The subject gains resist energy 10 against the energy type chosen, meaning that each time the creature is subjected to such damage (whether from a natural or magical source), that damage is reduced by 10 points before being applied to the creature's hit points. The value of the energy resistance granted increases to 20 points at 7th level and to a maximum of 30 points at 11th level. The spell protects the recipient's equipment as well. Resist energy absorbs only damage. The subject could still suffer unfortunate side effects. Resist energy overlaps (and does not stack with) <a href=\"Protection from Energy\">protection from energy</a>. If a character is warded by <a href=\"Protection from Energy\">protection from energy</a> and resist energy, the protection spell absorbs damage until its power is exhausted."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("10 min./level")->setSavingThrow("Fortitude negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Restoration")->setLongDescription(
            "This spell functions like lesser restoration, except that it also dispels temporary negative levels or one permanent negative level. If this spell is used to dispel a permanent negative level, it has a material component of diamond dust worth 1,000 gp. This spell cannot be used to dispel more than one permanent negative level possessed by a target in a 1-week period. Restoration cures all temporary ability damage, and it restores all points permanently drained from a single ability score (your choice if more than one is drained). It also eliminates any fatigue or exhaustion suffered by the target. "
        )->setCastingTime("1 minute")->setComponents("diamond dust worth 100 gp or 1,000 gp, see text")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("instantaneous")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Restoration, Greater")->setLongDescription(
            "This spell functions like <a href=\"Restoration, Lesser\">lesser restoration</a>, except that it dispels all permanent and temporary negative levels afflicting the healed creature. Greater restoration also dispels all magical effects penalizing the creature's abilities, cures all temporary ability damage, and restores all points permanently drained from all ability scores. It also eliminates fatigue and exhaustion, and removes all forms of insanity, confusion, and similar mental effects."
        )->setCastingTime("1 minute")->setComponents("diamond dust 5,000 gp")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Restoration, Lesser")->setLongDescription(
            "Lesser restoration dispels any magical effects reducing one of the subject's ability scores or cures 1d4 points of temporary ability damage to one of the subject's ability scores. It also eliminates any fatigue suffered by the character, and improves an exhausted condition to fatigued. It does not restore permanent ability drain."
        )->setCastingTime("3 rounds")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Resurrection")->setLongDescription(
            "This spell functions like <a href=\"Raise Dead\">raise dead</a>, except that you are able to restore life and complete strength to any deceased creature. The condition of the remains is not a factor. So long as some small portion of the creature's body still exists, it can be resurrected, but the portion receiving the spell must have been part of the creature's body at the time of death. (The remains of a creature hit by a <a href=\"Disintegrate\">disintegrate</a> spell count as a small portion of its body.) The creature can have been dead no longer than 10 years per caster level. Upon completion of the spell, the creature is immediately restored to full hit points, vigor, and health, with no loss of prepared spells. The subject of the spell gains one permanent negative level when it is raised, just as if it had been hit by an energy-draining creature. If the subject is 1st level, it takes 2 points of Constitution drain instead (if this would reduce its Con to 0 or less, it can't be resurrected).  You can resurrect someone killed by a death effect or someone who has been turned into an undead creature and then destroyed. You cannot resurrect someone who has died of old age. Constructs, elementals, outsiders, and undead creatures can't be resurrected."
        )->setCastingTime("")->setComponents("diamond worth 10,000 gp")->setRange("")->setTargets("")->setDuration(
                ""
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Reverse Gravity")->setLongDescription(
            "This spell reverses gravity in an area, causing unattached objects and creatures in the area to fall upward and reach the top of the area in 1 round. If a solid object (such as a ceiling) is encountered in this fall, falling objects and creatures strike it in the same manner as they would during a normal downward fall. If an object or creature reaches the top of the area without striking anything, it remains there, oscillating slightly, until the spell ends. At the end of the spell duration, affected objects and creatures fall downward. Provided it has something to hold onto, a creature caught in the area can attempt a Reflex save to secure itself when the spell strikes. Creatures who can fly or levitate can keep themselves from falling."
        )->setCastingTime("1 standard action")->setComponents("lodestone and iron filings")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Righteous Might")->setLongDescription(
            "Your height immediately doubles, and your weight increases by a factor of eight. This increase changes your size category to the next larger one. You gain a +4 size bonus to Strength and Constitution and take a -2 penalty to your Dexterity. You gain a +2 enhancement bonus to your natural armor. You gain DR 5/evil (if you normally channel positive energy) or DR 5/good (if you normally channel negative energy). At 15th level, this DR becomes 10/evil or 10/good (the maximum). Your size modifier for AC and attacks changes as appropriate to your new size category. This spell doesn't change your speed. Determine space and reach as appropriate to your new size. If insufficient room is available for the desired growth, you attain the maximum possible size and may make a Strength check (using your increased Strength) to burst any enclosures in the process (see Additional Rules for rules on breaking objects). If you fail, you are constrained without harm by the materials enclosing you--the spell cannot crush you by increasing your size. All equipment you wear or carry is similarly enlarged by the spell. Melee weapons deal more damage. Other magical properties are not affected by this spell. Any enlarged item that leaves your possession (including a projectile or thrown weapon) instantly returns to its normal size. This means that thrown and projectile weapons deal their normal damage. Magical effects that increase size do not stack."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Rope Trick")->setLongDescription(
            "When this spell is cast upon a piece of rope from 5 to 30 feet long, one end of the rope rises into the air until the whole rope hangs perpendicular to the ground, as if affixed at the upper end. The upper end is, in fact, fastened to an extradimensional space that is outside the usual multiverse of extradimensional spaces. Creatures in the extradimensional space are hidden, beyond the reach of spells (including divinations), unless those spells work across planes. The space holds as many as eight creatures (of any size). The rope cannot be removed or hidden. The rope can support up to 16,000 pounds. A weight greater than that can pull the rope free. Spells cannot be cast across the extradimensional interface, nor can area effects cross it. Those in the extradimensional space can see out of it as if a 3-foot-by-5-foot window were centered on the rope. The window is invisible, and even creatures that can see the window can't see through it. Anything inside the extradimensional space drops out when the spell ends. The rope can be climbed by only one person at a time. The rope trick spell enables climbers to reach a normal place if they do not climb all the way to the extradimensional space."
        )->setCastingTime("1 standard action")->setComponents(
                "powdered corn and a twisted loop of parchment"
            )->setRange("touch")->setTargets("one touched piece of rope from 5 ft. to 30 ft. long")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Rusting Grasp")->setLongDescription(
            "Any iron or iron alloy item you touch crumbles into rust. If the item is so large that it cannot fit within a 3-foot radius, a 3-foot-radius volume of the metal is rusted and destroyed. Magic items made of metal are immune to this spell. You may employ rusting grasp in combat with a successful melee touch attack. Rusting grasp used in this way instantaneously destroys 1d6 points of AC gained from metal armor (to the maximum amount of protection the armor offers) through corrosion.  Weapons in use by an opponent targeted by the spell are more difficult to grasp. You must succeed on a melee touch attack against the weapon. A metal weapon that is hit is destroyed. Striking at an opponent's weapon provokes an attack of opportunity. Also, you must touch the weapon and not the other way around. Against a ferrous creature, rusting grasp instantaneously deals 3d6 points of damage + 1 per caster level (maximum +15) per successful attack. The spell lasts for 1 round per level, and you can make one melee touch attack per round."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one nonmagical ferrous object (or the volume of the object within 3 ft. of the touched point) or one ferrous creature"
            )->setDuration("see text")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sanctuary")->setLongDescription(
            "Any opponent attempting to directly attack the warded creature, even with a targeted spell, must attempt a Will save. If the save succeeds, the opponent can attack normally and is unaffected by that casting of the spell. If the save fails, the opponent can't follow through with the attack, that part of its action is lost, and it can't directly attack the warded creature for the duration of the spell. Those not attempting to attack the subject remain unaffected. This spell does not prevent the warded creature from being attacked or affected by area of effect spells. The subject cannot attack without breaking the spell but may use nonattack spells or otherwise act."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 round/level")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Scare")->setLongDescription(
            "This spell functions like <a href=\"Cause Fear\">cause fear</a>, except that it causes all targeted creatures of less than 6 HD to become frightened. "
        )->setCastingTime("1 standard action")->setComponents("a bone from an undead creature")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets(
                "one living creature per three levels, no two of which can be more than 30 ft. apart"
            )->setDuration("1 round/level or 1 round; see text for cause fear")->setSavingThrow(
                "Will partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Scintillating Pattern")->setLongDescription(
            "A twisting pattern of coruscating colors weaves through the air, affecting creatures within. The spell affects a total number of HD of creatures equal to your caster level (maximum 20). Creatures with the fewest HD are affected first, and among creatures with equal HD, those who are closest to the spell's point of origin are affected first. HD that are not sufficient to affect a creature are wasted. The spell affects each subject according to its HD. 6 or less: Unconscious for 1d4 rounds, then stunned for 1d4 rounds, and then confused for 1d4 rounds. (Treat an unconscious result as stunned for nonliving creatures.) 7 to 12: Stunned for 1d4 rounds, then confused for an additional 1d4 rounds.  13 or more: Confused for 1d4 rounds.  Sightless creatures are not affected by scintillating pattern."
        )->setCastingTime("1 standard action")->setComponents("a crystal prism")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("concentration + 2 rounds")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Scorching Ray")->setLongDescription(
            "You blast your enemies with a searing beam of fire. You may fire one ray, plus one additional ray for every four levels beyond 3rd (to a maximum of three rays at 11th level). Each ray requires a ranged touch attack to hit and deals 4d6 points of fire damage. The rays may be fired at the same or different targets, but all rays must be aimed at targets within 30 feet of each other and fired simultaneously."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Screen")->setLongDescription(
            "This spell creates a powerful protection from scrying and observation. When casting the spell, you dictate what will and will not be observed in the spell's area. The illusion created must be stated in general terms. Once the conditions are set, they cannot be changed. Attempts to scry the area automatically detect the image stated by you with no save allowed. Sight and sound are appropriate to the illusion created. Direct observation may allow a save (as per a normal illusion), if there is cause to disbelieve what is seen. Even entering the area does not cancel the illusion or necessarily allow a save, assuming that hidden beings take care to stay out of the way of those affected by the illusion."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("24 hours")->setSavingThrow(
                "none or Will disbelief (if interacted with)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Scrying")->setLongDescription(
            "You can observe a creature at any distance. If the subject succeeds on a Will save, the spell fails. The difficulty of the save depends on how well your knowledge of the subject and what sort of physical connection (if any) you have to that creature. Furthermore, if the subject is on another plane, it gets a +5 bonus on its Will save. <table><tr><th>Knowledge</th><th>Will Save Modifier</th></tr><tr><td>None*</td><td>+10</td></tr><tr class=\"alt\"><td>Secondhand (you have heard of the subject)</td><td>+5</td></tr><tr><td>Firsthand (you have met the subject)</td><td>+0</td></tr><tr class=\"alt\"><td>Familiar (you know the subject well)</td><td>-5</td></tr><tr><td>Connention</td><td>Will Save Modifier</td></tr><tr class=\"alt\"><td>Likeness or picture</td><td>-2</td></tr><tr><td>Possession or garment</td><td>-4</td></tr><tr class=\"alt\"><td>Body part, lock of hair, bit of nail, etc.</td><td>-10</td></tr></table><i>*You must have some sort of connection (see below) to a creature of which you have no knowledge.</i> If the save fails, you can see and hear the subject and its surroundings (approximately 10 feet in all directions of the subject). If the subject moves, the sensor follows at a speed of up to 150 feet. As with all divination (scrying) spells, the sensor has your full visual acuity, including any magical effects. In addition, the following spells have a 5% chance per caster level of operating through the sensor: <a href=\"Detect Chaos\">detect chaos</a>, <a href=\"Detect Evil\">detect evil</a>, <a href=\"Detect Good\">detect good</a>, <a href=\"Detect Law\">detect law</a>, <a href=\"Detect Magic\">detect magic</a>, and <a href=\"Message\">message</a>. If the save succeeds, you can't attempt to scry on that subject again for at least 24 hours."
        )->setCastingTime("1 hour")->setComponents("a pool of water & a silver mirror worth 1,000 gp")->setRange(
                "see text"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Scrying, Greater")->setLongDescription(
            "This spell functions like <a href=\"Scrying\">scrying</a>, except as noted above. Additionally, all of the following spells function reliably through the sensor: <a href=\"Detect Chaos\">detect chaos</a>, <a href=\"Detect Evil\">detect evil</a>, <a href=\"Detect Good\">detect good</a>, <a href=\"Detect Law\">detect law</a>, <a href=\"Detect Magic\">detect magic</a>, <a href=\"Message\">message</a>, <a href=\"Read Magic\">read magic</a>, and <a href=\"Tongues\">tongues</a>."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets("")->setDuration(
                "1 hour/level"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sculpt Sound")->setLongDescription(
            "You can change the sounds that creatures or objects make. You can create sounds where none exist, deaden sounds, or transform sounds into other sounds. All affected creatures or objects must be transmuted in the same way. Once the transmutation is made, you cannot change it. You can change the qualities of sounds but cannot create words with which you are unfamiliar yourself.  A spellcaster whose voice is changed dramatically is unable to cast spells with verbal components."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature or object/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Searing Light")->setLongDescription(
            "Focusing divine power like a ray of the sun, you project a blast of light from your open palm. You must succeed on a ranged touch attack to strike your target. A creature struck by this ray of light takes 1d8 points of damage per two caster levels (maximum 5d8). An undead creature takes 1d6 points of damage per caster level (maximum 10d6), and an undead creature particularly vulnerable to bright light takes 1d8 points of damage per caster level (maximum 10d8). A construct or inanimate object takes only 1d6 points of damage per two caster levels (maximum 5d6)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Secret Chest")->setLongDescription(
            "You hide a chest on the Ethereal Plane for as long as 60 days and can retrieve it at will. The chest can contain up to 1 cubic foot of material per caster level (regardless of the chest's actual size, which is about 3 feet by 2 feet by 2 feet). If any living creatures are in the chest, there is a 75% chance that the spell simply fails. Once the chest is hidden, you can retrieve it by concentrating (a standard action), and it appears next to you. The chest must be exceptionally well crafted and expensive, constructed for you by master crafters. The cost of such a chest is never less than 5,000 gp. Once it is constructed, you must make a tiny replica (of the same materials and perfect in every detail) so that the miniature of the chest appears to be a perfect copy. (The replica costs 50 gp.) The chests are nonmagical and can be fitted with locks, wards, and so on, just as any normal chest can be. To hide the chest, you cast the spell while touching both the chest and the replica. The chest vanishes into the Ethereal Plane. You need the replica to recall the chest. After 60 days, there is a cumulative chance of 5% per day that the chest is irretrievably lost. If the miniature of the chest is lost or destroyed, there is no way, even with a <a href=\"Wish\">wish</a> spell, that the large chest can be summoned back, although an extraplanar expedition might be mounted to find it. Living things in the chest eat, sleep, and age normally, and they die if they run out of food, air, water, or whatever they need to survive."
        )->setCastingTime("10 minutes")->setComponents("the chest and its replica")->setRange("see text")->setTargets(
                "one chest and up to 1 cu. ft. of goods/caster level"
            )->setDuration("60 days or until discharged")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Secret Page")->setLongDescription(
            "Secret page alters the contents of a page so that it appears to be something entirely different. The text of a spell can be changed to show another spell of equal or lower level known by the caster. This spell cannot be used to change a spell contained on a scroll, but it can be used to hide a scroll. <a href=\"Explosive Runes\">Explosive runes</a> or <a href=\"Sepia Snake Sigil\">sepia snake sigil</a> can be cast upon the secret page. A <a href=\"Comprehend Languages\">comprehend languages</a> spell alone cannot reveal a secret page's contents. You are able to reveal the original contents by speaking a special word. You can then peruse the actual page and return it to its secret page form at will. You can also remove the spell by double repetition of the special word. A <a href=\"Detect Magic\">detect magic</a> spell reveals dim magic on the page in question but does not reveal its true contents. <a href=\"True Seeing\">True seeing</a> reveals the presence of the hidden material but does not reveal the contents unless cast in combination with <a href=\"Comprehend Languages\">comprehend languages</a>. A secret page spell can be dispelled, and the hidden writings can be destroyed by means of an <a href=\"Erase\">erase</a> spell."
        )->setCastingTime("10 minutes")->setComponents(
                "powdered herring scales and a vial of will-o'-wisp essence"
            )->setRange("touch")->setTargets("page touched, up to 3 sq. ft. in size")->setDuration(
                "permanent"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Secure Shelter")->setLongDescription(
            "You conjure a sturdy cottage or lodge made of material that is common in the area where the spell is cast. The floor is level, clean, and dry. The lodging resembles a normal cottage, with a sturdy door, two shuttered windows, and a small fireplace. The shelter must be heated as a normal dwelling, and extreme heat adversely affects it and its occupants. The dwelling does, however, provide considerable security otherwise--it is as strong as a normal stone building, regardless of its material composition. The dwelling resists flames and fire as if it were stone. It is impervious to normal missiles (but not the sort cast by siege engines or giants). The door, shutters, and even chimney are secure against intrusion, the former two being secured with <a href=\"Arcane Lock\">arcane lock</a> and the latter by an iron grate at the top and a narrow flue. In addition, these three areas are protected by an <a href=\"Alarm\">alarm</a> spell. Finally, an <a href=\"Unseen Servant\">unseen servant</a> is conjured to provide service to you for the duration of the shelter. The secure shelter contains crude furnishings--eight bunks, a trestle table, eight stools, and a writing desk."
        )->setCastingTime("10 minutes")->setComponents(
                "a chip of stone, sand, a drop of water, and a wood splinter"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("")->setDuration(
                "2 hours/level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("See Invisibility")->setLongDescription(
            "You can see any objects or beings that are invisible within your range of vision, as well as any that are ethereal, as if they were normally visible. Such creatures are visible to you as translucent shapes, allowing you easily to discern the difference between visible, invisible, and ethereal creatures. The spell does not reveal the method used to obtain invisibility. It does not reveal illusions or enable you to see through opaque objects. It does not reveal creatures who are simply hiding, concealed, or otherwise hard to see. See invisibility can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("talc and powdered silver")->setRange(
                "personal"
            )->setTargets("you")->setDuration("10 min./level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Seeming")->setLongDescription(
            "This spell functions like <a href=\"Disguise Self\">disguise self</a>, except that you can change the appearance of other people as well. Affected creatures resume their normal appearances if slain. Unwilling targets can negate the spell's effect on them by making Will saves or with spell resistance."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature per two levels, no two of which can be more than 30 ft. apart")->setDuration(
                "12 hours (D)"
            )->setSavingThrow("Will negates or Will disbelief (if interacted with)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sending")->setLongDescription(
            "You contact a particular creature with which you are familiar and send a short message of 25 words or less to the subject. The subject recognizes you if it knows you. It can answer in like manner immediately. A creature with an Intelligence score as low as 1 can understand the sending, though the subject's ability to react is limited as normal by its Intelligence. Even if the sending is received, the subject is not obligated to act upon it in any manner. If the creature in question is not on the same plane of existence as you are, there is a 5% chance that the sending does not arrive. (Local conditions on other planes may worsen this chance considerably.)"
        )->setCastingTime("10 minutes")->setComponents("fine copper wire")->setRange("see text")->setTargets(
                "one creature"
            )->setDuration("1 round; see text")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sepia Snake Sigil")->setLongDescription(
            "You cause a small symbol to appear in the text of a written work. The text containing the symbol must be at least 25 words long. When anyone reads the text containing the symbol, the sepia snake sigil springs into being, transforming into a large sepia serpent that strikes at the reader, provided there is line of effect between the symbol and the reader. Simply seeing the enspelled text is not sufficient to trigger the spell; the subject must deliberately read it. The target is entitled to a save to evade the snake's strike. If it succeeds, the sepia snake dissipates in a flash of brown light accompanied by a puff of dun-colored smoke and a loud noise. If the target fails its save, it is engulfed in a shimmering amber field of force and immobilized until released, either at your command or when 1d4 days + 1 day per caster level have elapsed. While trapped in the amber field of force, the subject does not age, breathe, grow hungry, sleep, or regain spells. It is preserved in a state of suspended animation, unaware of its surroundings. It can be damaged by outside forces (and perhaps even killed), since the field provides no protection against physical injury. However, a dying subject does not lose hit points or become stable until the spell ends. The hidden sigil cannot be detected by normal observation, and <a href=\"Detect Magic\">detect magic</a> reveals only that the entire text is magical. A <a href=\"Dispel Magic\">dispel magic</a> can remove the sigil. An <a href=\"Erase\">erase</a> spell destroys the entire page of text. Sepia snake sigil can be cast in combination with other spells that hide or garble text, such as <a href=\"Secret Page\">secret page</a>."
        )->setCastingTime("10 minutes")->setComponents("powdered amber worth 500 gp and a snake scale")->setRange(
                "touch"
            )->setTargets("one touched book or written work")->setDuration(
                "permanent or until discharged; until released or 1d4 days + 1 day/level; see text"
            )->setSavingThrow("Reflex negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sequester")->setLongDescription(
            "When cast, this spell prevents <a href=\"Divination\">divination</a> spells from detecting or locating the target and also renders the affected target invisible (as the <a href=\"Invisibility\">invisibility</a> spell). The spell does not prevent the subject from being discovered through tactile means or through the use of devices. Creatures affected by sequester become comatose and are effectively in a state of suspended animation until the spell ends. Note: The Will save prevents an attended or magical object from being sequestered. There is no save to see the sequestered creature or object or to detect it with a <a href=\"Divination\">divination</a> spell."
        )->setCastingTime("1 standard action")->setComponents("a basilisk eyelash and gum arabic")->setRange(
                "touch"
            )->setTargets("one willing creature or object (up to a 2-ft. cube/level) touched")->setDuration(
                "1 day/level (D)"
            )->setSavingThrow("none or Will negates (object)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shades")->setLongDescription(
            "This spell functions like <a href=\"Shadow Conjuration\">shadow conjuration</a>, except that it mimics conjuration spells of 8th level or lower. The illusory conjurations created deal four-fifths (80%) damage to nonbelievers, and nondamaging effects are 80% likely to work against nonbelievers."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets("")->setDuration(
                "see text"
            )->setSavingThrow("Will disbelief (if interacted with)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shadow Conjuration")->setLongDescription(
            "You use material from the Plane of Shadow to shape quasi-real illusions of one or more creatures, objects, or forces. Shadow conjuration can mimic any sorcerer or wizard conjuration (summoning) or conjuration (creation) spell of 3rd level or lower. Shadow conjurations are only one-fifth (20%) as strong as the real things, though creatures who believe the shadow conjurations to be real are affected by them at full strength. Any creature that interacts with the spell can make a Will save to recognize its true nature. Spells that deal damage have normal effects unless the affected creature succeeds on a Will save. Each disbelieving creature takes only one-fifth (20%) damage from the attack. If the disbelieved attack has a special effect other than damage, that effect is only 20% likely to occur. Regardless of the result of the save to disbelieve, an affected creature is also allowed any save that the spell being simulated allows, but the save DC is set according to shadow conjuration's level (4th) rather than the spell's normal level. In addition, any effect created by shadow conjuration allows spell resistance, even if the spell it is simulating does not. Shadow objects or substances have normal effects except against those who disbelieve them. Against disbelievers, they are 20% likely to work. A shadow creature has one-fifth the hit points of a normal creature of its kind (regardless of whether it's recognized as shadowy). It deals normal damage and has all normal abilities and weaknesses. Against a creature that recognizes it as a shadow creature, however, the shadow creature's damage is one-fifth (20%) normal, and all special abilities that do not deal lethal damage are only 20% likely to work. (Roll for each use and each affected character separately.) Furthermore, the shadow creature's AC bonuses are just one-fifth as large. A creature that succeeds on its save sees the shadow conjurations as transparent images superimposed on vague, shadowy forms. Objects automatically succeed on their Will saves against this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets("")->setDuration(
                "see text"
            )->setSavingThrow("Will disbelief (if interacted with)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shadow Conjuration, Greater")->setLongDescription(
            "This spell functions like <a href=\"Shadow Conjuration\">shadow conjuration</a>, except that it duplicates any sorcerer or wizard conjuration (summoning) or conjuration (creation) spell of 6th level or lower. The illusory conjurations created deal three-fifths (60%) damage to nonbelievers, and nondamaging effects are 60% likely to work against nonbelievers."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets("")->setDuration(
                "see text"
            )->setSavingThrow("Will disbelief (if interacted with)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shadow Evocation")->setLongDescription(
            "You tap energy from the Plane of Shadow to cast a quasi-real, illusory version of a sorcerer or wizard evocation spell of 4th level or lower. Spells that deal damage have normal effects unless an affected creature succeeds on a Will save. Each disbelieving creature takes only one-fifth damage from the attack. If the disbelieved attack has a special effect other than damage, that effect is one-fifth as strong (if applicable) or only 20% likely to occur. If recognized as a shadow evocation, a damaging spell deals only one-fifth (20%) damage. Regardless of the result of the save to disbelieve, an affected creature is also allowed any save (or spell resistance) that the spell being simulated allows, but the save DC is set according to shadow evocation's level (5th) rather than the spell's normal level. Nondamaging effects have normal effects except against those who disbelieve them. Against disbelievers, they have no effect. Objects automatically succeed on their Will saves against this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets("")->setDuration(
                "see text"
            )->setSavingThrow("Will disbelief (if interacted with)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shadow Evocation, Greater")->setLongDescription(
            "This spell functions like <a href=\"Shadow Evocation\">shadow evocation</a>, except that it enables you to create partially real, illusory versions of sorcerer or wizard evocation spells of 7th level or lower. If recognized as a greater shadow evocation, a damaging spell deals only three-fifths (60%) damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("see text")->setTargets("")->setDuration(
                "see text"
            )->setSavingThrow("Will disbelief (if interacted with)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shadow Walk")->setLongDescription(
            "To use the shadow walk spell, you must be in an area of dim light. You and any creature you touch are then transported along a coiling path of shadowstuff to the edge of the Material Plane where it borders the Plane of Shadow. The effect is largely illusory, but the path is quasi-real. You can take more than one creature along with you (subject to your level limit), but all must be touching each other. In the region of shadow, you move at a rate of 50 miles per hour, moving normally on the borders of the Plane of Shadow but much more rapidly relative to the Material Plane. Thus, you can use this spell to travel rapidly by stepping onto the Plane of Shadow, moving the desired distance, and then stepping back onto the Material Plane. Because of the blurring of reality between the Plane of Shadow and the Material Plane, you can't make out details of the terrain or areas you pass over during transit, nor can you predict perfectly where your travel will end. It's impossible to judge distances accurately, making the spell virtually useless for scouting or spying. Furthermore, when the spell effect ends, you are shunted 1d10 x 100 feet in a random horizontal direction from your desired endpoint. If this would place you within a solid object, you are shunted 1d10 x 1,000 feet in the same direction. If this would still place you within a solid object, you (and any creatures with you) are shunted to the nearest empty space available, but the strain of this activity renders each creature fatigued (no save). Shadow walk can also be used to travel to other planes that border on the Plane of Shadow, but this usage requires the transit of the Plane of Shadow to arrive at a border with another plane of reality. The transit of the Plane of Shadow requires 1d4 hours. Any creatures touched by you when shadow walk is cast also make the transition to the borders of the Plane of Shadow. They may opt to follow you, wander off through the plane, or stumble back into the Material Plane (50% chance for either of the latter results if they are lost or abandoned by you). Creatures unwilling to accompany you into the Plane of Shadow receive a Will saving throw, negating the effect if successful."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "up to one touched creature/level"
            )->setDuration("1 hour/level (D)")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shambler")->setLongDescription(
            "The shambler spell creates 1d4+2 shambling mounds with the advanced template. The creatures willingly aid you in combat or battle, perform a specific mission, or serve as bodyguards. The creatures remain with you for 7 days unless you dismiss them. If the shamblers are created only for guard duty, however, the duration of the spell is 7 months. In this case, the shamblers can only be ordered to guard a specific site or location. Shamblers summoned to guard duty cannot move outside the spell's range, which is measured from the point where each first appeared. You can only have one shambler spell in effect at one time. If you cast this spell while another casting is still in effect, the previous casting is dispelled. The shamblers have resistance to fire as normal shambling mounds do only if the terrain where they are summoned is rainy, marshy, or damp."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("7 days or 7 months (D); see text")->setSavingThrow(
                "none"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shapechange")->setLongDescription(
            "This spell allows you to take the form of a wide variety of creatures. This spell can function as <a href=\"Alter Self\">alter self</a>, <a href=\"Beast Shape IV\">beast shape IV</a>, <a href=\"Elemental Body IV\">elemental body IV</a>, <a href=\"Form of the Dragon III\">form of the dragon III</a>, <a href=\"Giant Form II\">giant form II</a>, and <a href=\"Plant Shape III\">plant shape III</a> depending on what form you take. You can change form once each round as a free action. The change takes place either immediately before your regular action or immediately after it, but not during the action. "
        )->setCastingTime("1 standard action")->setComponents("jade circlet worth 1,500 gp")->setRange(
                "personal"
            )->setTargets("you")->setDuration("10 min./level (D)")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shatter")->setLongDescription(
            "Shatter creates a loud, ringing noise that breaks brittle, nonmagical objects; sunders a single solid, nonmagical object; or damages a crystalline creature. Used as an area attack, shatter destroys nonmagical objects of crystal, glass, ceramic, or porcelain. All such objects within a 5-foot radius of the point of origin are smashed into dozens of pieces by the spell. Objects weighing more than 1 pound per your level are not affected, but all other objects of the appropriate composition are shattered. Alternatively, you can target shatter against a single solid nonmagical object, regardless of composition, weighing up to 10 pounds per caster level. Targeted against a crystalline creature (of any weight), shatter deals 1d6 points of sonic damage per caster level (maximum 10d6), with a Fortitude save for half damage."
        )->setCastingTime("1 standard action")->setComponents("a chip of mica")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one solid object or one crystalline creature")->setDuration("instantaneous")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shield")->setLongDescription(
            "Shield creates an invisible shield of force that hovers in front of you. It negates magic missile attacks directed at you. The disk also provides a +4 shield bonus to AC. This bonus applies against incorporeal touch attacks, since it is a force effect. The shield has no armor check penalty or arcane spell failure chance."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shield of Faith")->setLongDescription(
            "This spell creates a shimmering, magical field around the target that averts and deflects attacks. The spell grants the subject a +2 deflection bonus to AC, with an additional +1 to the bonus for every six levels you have (maximum +5 deflection bonus at 18th level)."
        )->setCastingTime("1 standard action")->setComponents("parchment with a holy text written on it")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shield of Law")->setLongDescription(
            "A dim, blue glow surrounds the subjects, protecting them from attacks, granting them resistance to spells cast by chaotic creatures, and slowing chaotic creatures when they strike the subjects. This abjuration has four effects. First, each warded creature gains a +4 deflection bonus to AC and a +4 resistance bonus on saves. Unlike <a href=\"Protection from Chaos\">protection from chaos</a>, this benefit applies against all attacks, not just against attacks by chaotic creatures. Second, a warded creature gains spell resistance 25 against chaotic spells and spells cast by chaotic creatures. Third, the abjuration protects you from possession and mental influence, just as <a href=\"Protection from Chaos\">protection from chaos</a> does. Finally, if a chaotic creature succeeds on a melee attack against a warded creature, the attacker is slowed (Will save negates, as the slow spell, but against shield of law's save DC)."
        )->setCastingTime("1 standard action")->setComponents("a reliquary worth 500 gp")->setRange(
                "20 ft."
            )->setTargets("one creature/level in a 20-ft.-radius burst centered on you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shield Other")->setLongDescription(
            "This spell wards the subject and creates a mystic connection between you and the subject so that some of its wounds are transferred to you. The subject gains a +1 deflection bonus to AC and a +1 resistance bonus on saves. Additionally, the subject takes only half damage from all wounds and attacks (including those dealt by special abilities) that deal hit point damage. The amount of damage not taken by the warded creature is taken by you. Forms of harm that do not involve hit points, such as charm effects, temporary ability damage, level draining, and death effects, are not affected. If the subject suffers a reduction of hit points from a lowered Constitution score, the reduction is not split with you because it is not hit point damage. When the spell ends, subsequent damage is no longer divided between the subject and you, but damage already split is not reassigned to the subject. If you and the subject of the spell move out of range of each other, the spell ends."
        )->setCastingTime("1 standard action")->setComponents(
                "a pair of platinum rings worth 50 gp worn by both you and the target"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("one creature")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shillelagh")->setLongDescription(
            "Your own nonmagical club or quarterstaff becomes a weapon with a +1 enhancement bonus on attack and damage rolls. A quarterstaff gains this enhancement for both ends of the weapon. It deals damage as if it were two size categories larger (a Small club or quarterstaff so transmuted deals 1d8 points of damage, a Medium 2d6, and a Large 3d6), +1 for its enhancement bonus. These effects only occur when the weapon is wielded by you. If you do not wield it, the weapon behaves as if unaffected by this spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched nonmagical oak club or quarterstaff"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shocking Grasp")->setLongDescription(
            "Your successful melee touch attack deals 1d6 points of electricity damage per caster level (maximum 5d6). When delivering the jolt, you gain a +3 bonus on attack rolls if the opponent is wearing metal armor (or is carrying a metal weapon or is made of metal)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature or object touched"
            )->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shout")->setLongDescription(
            "You emit an ear-splitting yell that deafens and damages creatures in its path. Any creature within the area is deafened for 2d6 rounds and takes 5d6 points of sonic damage. A successful save negates the deafness and reduces the damage by half. Any exposed brittle or crystalline object or crystalline creature takes 1d6 points of sonic damage per caster level (maximum 15d6). An affected creature is allowed a Fortitude save to reduce the damage by half, and a creature holding fragile objects can negate damage to them with a successful Reflex save. A shout spell cannot penetrate a <a href=\"Silence\">silence</a> spell."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("30 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("Fortitude partial or Reflex negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shout, Greater")->setLongDescription(
            "This spell functions like <a href=\"Shout\">shout</a>, except that the cone deals 10d6 points of sonic damage (or 1d6 points of sonic damage per caster level, maximum 20d6, against exposed brittle or crystalline objects or crystalline creatures). It also causes creatures to be stunned for 1 round and deafened for 4d6 rounds. A creature in the area of the cone can negate the stunning and halve both the damage and the duration of the deafness with a successful Fortitude save. A creature holding vulnerable objects can attempt a Reflex save to negate the damage to those objects."
        )->setCastingTime("1 standard action")->setComponents("a metal or ivory horn")->setRange("60 ft.")->setTargets(
                ""
            )->setDuration("instantaneous")->setSavingThrow(
                "Fortitude partial or Reflex negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Shrink Item")->setLongDescription(
            "You are able to shrink one nonmagical item (if it is within the size limit) to 1/16 of its normal size in each dimension (to about 1/4,000 the original volume and mass). This change effectively reduces the object's size by four categories. Optionally, you can also change its now shrunken composition to a clothlike one. Objects changed by a shrink item spell can be returned to normal composition and size merely by tossing them onto any solid surface or by a word of command from the original caster. Even a burning fire and its fuel can be shrunk by this spell. Restoring the shrunken object to its normal size and composition ends the spell. Shrink item can be made permanent with a <a href=\"Permanency\">permanency</a> spell, in which case the affected object can be shrunk and expanded an indefinite number of times, but only by the original caster."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched object of up to 2 cu. ft./level"
            )->setDuration("1 day/level; see text")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Silence")->setLongDescription(
            "Upon the casting of this spell, complete silence prevails in the affected area. All sound is stopped: Conversation is impossible, spells with verbal components cannot be cast, and no noise whatsoever issues from, enters, or passes through the area. The spell can be cast on a point in space, but the effect is stationary unless cast on a mobile object. The spell can be centered on a creature, and the effect then radiates from the creature and moves as it moves. An unwilling creature can attempt a Will save to negate the spell and can use spell resistance, if any. Items in a creature's possession or magic items that emit sound receive the benefits of saves and spell resistance, but unattended objects and points in space do not. Creatures in an area of a silence spell are immune to sonic or language-based attacks, spells, and effects."
        )->setCastingTime("1 round")->setComponents("")->setRange("long (400 ft. + 40 ft./level)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow(": Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Silent Image")->setLongDescription(
            "This spell creates the visual illusion of an object, creature, or force, as visualized by you. The illusion does not create sound, smell, texture, or temperature. You can move the image within the limits of the size of the effect."
        )->setCastingTime("1 standard action")->setComponents("a bit of fleece")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("concentration")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Simulacrum")->setLongDescription(
            "Simulacrum creates an illusory duplicate of any creature. The duplicate creature is partially real and formed from ice or snow. It appears to be the same as the original, but it has only half of the real creature's levels or HD (and the appropriate hit points, feats, skill ranks, and special abilities for a creature of that level or HD). You can't create a simulacrum of a creature whose HD or levels exceed twice your caster level. You must make a Disguise check when you cast the spell to determine how good the likeness is. A creature familiar with the original might detect the ruse with a successful Perception check (opposed by the caster's Disguise check) or a DC 20 Sense Motive check. At all times, the simulacrum remains under your absolute command. No special telepathic link exists, so command must be exercised in some other manner. A simulacrum has no ability to become more powerful. It cannot increase its level or abilities. If reduced to 0 hit points or otherwise destroyed, it reverts to snow and melts instantly into nothingness. A complex process requiring at least 24 hours, 100 gp per hit point, and a fully equipped magical laboratory can repair damage to a simulacrum."
        )->setCastingTime("12 hours")->setComponents(
                "ice sculpture of the target plus powdered rubies worth 500 gp per HD of the simulacrum"
            )->setRange("0 ft.")->setTargets("")->setDuration("instantaneous")->setSavingThrow(
                "none"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Slay Living")->setLongDescription(
            "You can attempt to slay any one living creature. When you cast this spell, your hand seethes with eerie dark fire. You must succeed on a melee touch attack to touch the target. The target takes 12d6 points of damage + 1 point per caster level. If the target's Fortitude saving throw succeeds, it instead takes 3d6 points of damage + 1 point per caster level. The subject might die from damage even if it succeeds on its saving throw."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sleep")->setLongDescription(
            "A sleep spell causes a magical slumber to come upon 4 HD of creatures. Creatures with the fewest HD are affected first. Among creatures with equal HD, those who are closest to the spell's point of origin are affected first. HD that are not sufficient to affect a creature are wasted. Sleeping creatures are helpless. Slapping or wounding awakens an affected creature, but normal noise does not. Awakening a creature is a standard action (an application of the aid another action). Sleep does not target unconscious creatures, constructs, or undead creatures."
        )->setCastingTime("1 round")->setComponents("fine sand, rose petals, or a live cricket")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sleet Storm")->setLongDescription(
            "Driving sleet blocks all sight (even darkvision) within it and causes the ground in the area to be icy. A creature can walk within or through the area of sleet at half normal speed with a DC 10 Acrobatics check. Failure means it can't move in that round, while failure by 5 or more means it falls (see the Acrobatics skill for details). The sleet extinguishes torches and small fires."
        )->setCastingTime("1 standard action")->setComponents("dust and water")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Slow")->setLongDescription(
            "An affected creature moves and attacks at a drastically slowed rate. Creatures affected by this spell are staggered and can take only a single move action or standard action each turn, but not both (nor may it take full-round actions). Additionally, it takes a -1 penalty on attack rolls, AC, and Reflex saves. A slowed creature moves at half its normal speed (round down to the next 5-foot increment), which affects the creature's jumping distance as normal for decreased speed. Multiple slow effects don't stack. Slow counters and dispels <a href=\"Haste\">haste</a>."
        )->setCastingTime("1 standard action")->setComponents("a drop of molasses")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 round/level"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Snare")->setLongDescription(
            "This spell enables you to make a snare that functions as a magic trap. The snare can be made from any supple vine, a thong, or a rope. When you cast snare upon it, the cordlike object blends with its surroundings (DC 23 Perception check for a character with the trapfinding ability to locate). One end of the snare is tied in a loop that contracts around one or more of the limbs of any creature stepping inside the circle. If a strong and supple tree is nearby, the snare can be fastened to it. The spell causes the tree to bend, straightening when the loop is triggered, dealing 1d6 points of damage to the creature trapped and lifting it off the ground by the trapped limb or limbs. If no such tree is available, the cordlike object tightens around the creature, dealing no damage but causing it to be entangled. The snare is magical. To escape, a trapped creature must make a DC 23 Escape Artist check or a DC 23 Strength check that is a full-round action. The snare has AC 7 and 5 hit points. A successful escape from the snare breaks the loop and ends the spell."
        )->setCastingTime("3 rounds")->setComponents("")->setRange("touch")->setTargets(
                "touched nonmagical circle of vine, rope, or thong with a 2 ft. diameter + 2 ft./level"
            )->setDuration("Until triggered or broken")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Soften Earth and Stone")->setLongDescription(
            "When this spell is cast, all natural, undressed earth or stone in the spell's area is softened. Wet earth becomes thick mud, dry earth becomes loose sand or dirt, and stone becomes soft clay that is easily molded or chopped. You affect a 10-foot square area to a depth of 1 to 4 feet, depending on the toughness or resilience of the ground at that spot. Magical, enchanted, dressed, or worked stone cannot be affected. Earth or stone creatures are not affected. A creature in mud must succeed on a Reflex save or be caught for 1d2 rounds and unable to move, attack, or cast spells. A creature that succeeds on its save can move through the mud at half speed, and it can't run or charge. Loose dirt is not as troublesome as mud, but all creatures in the area can move at only half their normal speed and can't run or charge over the surface. Stone softened into clay does not hinder movement, but it does allow characters to cut, shape, or excavate areas they may not have been able to affect before. While this spell does not affect dressed or worked stone, cavern ceilings or vertical surfaces such as cliff faces can be affected. Usually, this causes a moderate collapse or landslide as the loosened material peels away from the face of the wall or roof and falls (treat as a cave-in with no bury zone, see Environment). A moderate amount of structural damage can be dealt to a manufactured structure by softening the ground beneath it, causing it to settle. However, most well-built structures will only be damaged by this spell, not destroyed."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Solid Fog")->setLongDescription(
            "This spell functions like <a href=\"Fog Cloud\">fog cloud</a>, but in addition to obscuring sight, the solid fog is so thick that it impedes movement. Creatures moving through a solid fog move at half their normal speed and take a -2 penalty on all melee attack and melee damage rolls. The vapors prevent effective ranged weapon attacks (except for magic rays and the like). A creature or object that falls into solid fog is slowed so that each 10 feet of vapor that it passes through reduces the falling damage by 1d6. A creature cannot take a 5-foot-step while in solid fog. Solid fog, and effects that work like solid fog, do not stack with each other in terms of slowed movement and attack penalties. Unlike normal fog, only a severe wind (31+ mph) disperses these vapors, and it does so in 1 round. Solid fog can be made permanent with a <a href=\"Permanency\">permanency</a> spell. A permanent solid fog dispersed by wind reforms in 10 minutes."
        )->setCastingTime("")->setComponents("powdered peas and an animal hoof")->setRange("")->setTargets(
                ""
            )->setDuration("1 min./level")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Song of Discord")->setLongDescription(
            "This spell causes those within the area to turn on each other rather than attack their foes. Each affected creature has a 50% chance to attack the nearest target each round. (Roll to determine each creature's behavior every round at the beginning of its turn.) A creature that does not attack its nearest neighbor is free to act normally for that round. Creatures forced by a song of discord to attack their fellows employ all methods at their disposal, choosing their deadliest spells and most advantageous combat tactics. They do not, however, harm targets that have fallen unconscious."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Soul Bind")->setLongDescription(
            "You draw the soul from a newly dead body and imprison it in a black sapphire gem. The subject must have been dead no more than 1 round per caster level. The soul, once trapped in the gem, cannot be returned through <a href=\"Clone\">clone</a>, <a href=\"Raise Dead\">raise dead</a>, <a href=\"Reincarnate\">reincarnate</a>, <a href=\"Resurrection\">resurrection</a>, <a href=\"True Resurrection\">true resurrection</a>, or even a <a href=\"Miracle\">miracle</a> or a <a href=\"Wish\">wish</a>. Only by destroying the gem or dispelling the spell on the gem can one free the soul (which is then still dead). The focus for this spell is a black sapphire of at least 1,000 gp value for every HD possessed by the creature whose soul is to be bound. If the gem is not valuable enough, it shatters when the binding is attempted. (While creatures have no concept of level or HD as such, the value of the gem needed to trap an individual can be researched.)"
        )->setCastingTime("1 standard action")->setComponents("see text")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("corpse")->setDuration("permanent")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sound Burst")->setLongDescription(
            "You blast an area with a tremendous cacophony. Every creature in the area takes 1d8 points of sonic damage and must succeed on a Fortitude save to avoid being stunned for 1 round. Creatures that cannot hear are not stunned but are still damaged."
        )->setCastingTime("1 standard action")->setComponents("a musical instrument")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Fortitude partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Speak with Animals")->setLongDescription(
            "You can ask questions of and receive answers from animals, but the spell doesn't make them any more friendly than normal. Wary and cunning animals are likely to be terse and evasive, while the more stupid ones make inane comments. If an animal is friendly toward you, it may do some favor or service for you."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Speak with Dead")->setLongDescription(
            "You grant the semblance of life to a corpse, allowing it to answer questions. You may ask one question per two caster levels. The corpse's knowledge is limited to what it knew during life, including the languages it spoke. Answers are brief, cryptic, or repetitive, especially if the creature would have opposed you in life. If the dead creature's alignment was different from yours, the corpse gets a Will save to resist the spell as if it were alive. If successful, the corpse can refuse to answer your questions or attempt to deceive you, using Bluff. The soul can only speak about what it knew in life. It cannot answer any questions that pertain to events that occurred after its death. If the corpse has been subject to speak with dead within the past week, the new spell fails. You can cast this spell on a corpse that has been deceased for any amount of time, but the body must be mostly intact to be able to respond. A damaged corpse may be able to give partial answers or partially correct answers, but it must at least have a mouth in order to speak at all. This spell does not affect a corpse that has been turned into an undead creature."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("10 ft.")->setTargets(
                "one dead creature"
            )->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Speak with Plants")->setLongDescription(
            "You can communicate with normal plants and plant creatures, and can ask questions of and receive answers from them. A normal plant's sense of its surroundings is limited, so it won't be able to give (or recognize) detailed descriptions of creatures or answer questions about events outside its immediate vicinity. The spell doesn't make plant creatures any more friendly or cooperative than normal. Furthermore, wary and cunning plant creatures are likely to be terse and evasive, while the more stupid ones may make inane comments. If a plant creature is friendly, it may do some favor or service for you."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spectral Hand")->setLongDescription(
            "A ghostly hand shaped from your life force materializes and moves as you desire, allowing you to deliver low-level, touch range spells at a distance. On casting the spell, you lose 1d4 hit points that return when the spell ends (even if it is dispelled), but not if the hand is destroyed. (The hit points can be healed as normal.) For as long as the spell lasts, any touch range spell of 4th level or lower that you cast can be delivered by the spectral hand. The spell gives you a +2 bonus on your melee touch attack roll, and attacking with the hand counts normally as an attack. The hand always strikes from your direction. The hand cannot flank targets like a creature can. After it delivers a spell, or if it goes beyond the spell range or goes out of your sight, the hand returns to you and hovers. The hand is incorporeal and thus cannot be harmed by normal weapons. It has improved evasion (half damage on a failed Reflex save and no damage on a successful save), your save bonuses, and an AC of 22 (+8 size, +4 natural armor). Your Intelligence modifier applies to the hand's AC as if it were the hand's Dexterity modifier. The hand has 1 to 4 hit points, the same number that you lost in creating it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spell Immunity")->setLongDescription(
            "The warded creature is immune to the effects of one specified spell for every four levels you have. The spells must be of 4th level or lower. The warded creature effectively has unbeatable spell resistance regarding the specified spell or spells. Naturally, that immunity doesn't protect a creature from spells for which spell resistance doesn't apply. Spell immunity protects against spells, spell-like effects of magic items, and innate spell-like abilities of creatures. It does not protect against supernatural or extraordinary abilities, such as breath weapons or gaze attacks. Only a particular spell can be protected against, not a certain domain or school of spells or a group of spells that are similar in effect. A creature can have only one spell immunity or greater spell immunity spell in effect on it at a time."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("10 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spell Immunity, Greater")->setLongDescription(
            "This spell functions like <a href=\"Spell Immunity\">spell immunity</a>, except the immunity applies to spells of 8th level or lower. A creature can have only one <a href=\"Spell Immunity\">spell immunity</a> or greater spell immunity spell in effect on it at a time."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("10 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spell Resistance")->setLongDescription(
            "The target gains spell resistance equal to 12 + your caster level."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spellstaff")->setLongDescription(
            "You store one spell that you can normally cast in a wooden quarterstaff. Only one such spell can be stored in a staff at a given time, and you cannot have more than one spellstaff at any given time. You can cast a spell stored within a staff just as though it were among those you had prepared, but it does not count against your normal allotment for a given day. You use up any applicable material components required to cast the spell when you store it in the spellstaff."
        )->setCastingTime("10 minutes")->setComponents("the staff that stores the spell")->setRange(
                "touch"
            )->setTargets("wooden quarterstaff touched")->setDuration("permanent until discharged (D)")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spell Turning")->setLongDescription(
            "Spells and spell-like effects targeted on you are turned back upon the original caster. The abjuration turns only spells that have you as a target. Effect and area spells are not affected. Spell turning also fails to stop touch range spells. From seven to ten (1d4+6) spell levels are affected by the turning. The exact number is rolled secretly. When you are targeted by a spell of higher level than the amount of spell turning you have left, that spell is partially turned. Subtract the amount of spell turning left from the spell level of the incoming spell, then divide the result by the spell level of the incoming spell to see what fraction of the effect gets through. For damaging spells, you and the caster each take a fraction of the damage. For nondamaging spells, each of you has a proportional chance to be the one who is affected. If you and a spellcasting attacker are both warded by spell turning effects in operation, a resonating field is created. Roll randomly to determine the result. <table><tr><th>d10</th><th>Effect</th></tr><tr><td>01-70</td><td>Spell drains away without effect.</td></tr><tr class=\"alt\"><td>71-80</td><td>Spell affects both of you equally at full effect.</td></tr><tr><td>81-97</td><td>Both turning effects are rendered nonfunctional for 1d4 minutes.</td></tr><tr class=\"alt\"><td>98-100</td><td>Both of you go through a rift into another plane.</td></tr></table>"
        )->setCastingTime("1 standard action")->setComponents("a small silver mirror")->setRange(
                "personal"
            )->setTargets("you")->setDuration("until expended or 10 min./level")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spider Climb")->setLongDescription(
            "The subject can climb and travel on vertical surfaces or even traverse ceilings as well as a spider does. The affected creature must have its hands free to climb in this manner. The subject gains a climb speed of 20 feet and a +8 racial bonus on Climb skill checks; furthermore, it need not make Climb checks to traverse a vertical or horizontal surface (even upside down). A spider climbing creature retains its Dexterity bonus to Armor Class (if any) while climbing, and opponents get no special bonus to their attacks against it. It cannot, however, use the run action while climbing."
        )->setCastingTime("1 standard action")->setComponents("a live spider")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("10 min./level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spike Growth")->setLongDescription(
            "Any ground-covering vegetation in the spell's area becomes very hard and sharply pointed without changing its appearance. In areas of bare earth, roots and rootlets act in the same way. Typically, spike growth can be cast in any outdoor setting except open water, ice, heavy snow, sandy desert, or bare stone. Any creature moving on foot into or through the spell's area takes 1d4 points of piercing damage for each 5 feet of movement through the spiked area. Any creature that takes damage from this spell must also succeed on a Reflex save or suffer injuries to its feet and legs that slow its land speed by half. This speed penalty lasts for 24 hours or until the injured creature receives a cure spell (which also restores lost hit points). Another character can remove the penalty by taking 10 minutes to dress the injuries and succeeding on a <a href=\"Heal\">Heal</a> check against the spell's save DC. Magic traps are hard to detect. A rogue (only) can use the Perception skill to find a spike growth. The DC is 25 + spell level, or DC 28 for spike growth (or DC 27 for spike growth cast by a ranger). Spike growth can't be disabled with the Disable Device skill."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 hour/level (D)")->setSavingThrow("Reflex partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spike Stones")->setLongDescription(
            "Rocky ground, stone floors, and similar surfaces shape themselves into long, sharp points that blend into the background. Spike stones impede progress through an area and deal damage. Any creature moving on foot into or through the spell's area moves at half speed. In addition, each creature moving through the area takes 1d8 points of piercing damage for each 5 feet of movement through the spiked area. Any creature that takes damage from this spell must also succeed on a Reflex save to avoid injuries to its feet and legs. A failed save causes the creature's speed to be reduced to half normal for 24 hours or until the injured creature receives a cure spell (which also restores lost hit points). Another character can remove the penalty by taking 10 minutes to dress the injuries and succeeding on a <a href=\"Heal\">Heal</a> check against the spell's save DC. Magic traps such as spike stones are hard to detect. A rogue (only) can use the Perception skill to find spike stones. The DC is 25 + spell level, or DC 29 for spike stones. Spike stones is a magic trap that can't be disabled with the Disable Device skill."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 hour/level (D)")->setSavingThrow("Reflex partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Spiritual Weapon")->setLongDescription(
            "A weapon made of force appears and attacks foes at a distance, as you direct it, dealing 1d8 force damage per hit, + 1 point per three caster levels (maximum +5 at 15th level). The weapon takes the shape of a weapon favored by your deity or a weapon with some spiritual significance or symbolism to you (see below) and has the same threat range and critical multipliers as a real weapon of its form. It strikes the opponent you designate, starting with one attack in the round the spell is cast and continuing each round thereafter on your turn. It uses your base attack bonus (possibly allowing it multiple attacks per round in subsequent rounds) plus your Wisdom modifier as its attack bonus. It strikes as a spell, not as a weapon, so for example, it can damage creatures that have damage reduction. As a force effect, it can strike incorporeal creatures without the reduction in damage associated with incorporeality. The weapon always strikes from your direction. It does not get a flanking bonus or help a combatant get one. Your feats or combat actions do not affect the weapon. If the weapon goes beyond the spell range, if it goes out of your sight, or if you are not directing it, the weapon returns to you and hovers. Each round after the first, you can use a move action to redirect the weapon to a new target. If you do not, the weapon continues to attack the previous round's target. On any round that the weapon switches targets, it gets one attack. Subsequent rounds of attacking that target allow the weapon to make multiple attacks if your base attack bonus would allow it to. Even if the spiritual weapon is a ranged weapon, use the spell's range, not the weapon's normal range increment, and switching targets still is a move action. A spiritual weapon cannot be attacked or harmed by physical attacks, but <a href=\"Dispel Magic\">dispel magic</a>, <a href=\"Disintegrate\">disintegrate</a>, a sphere of annihilation, or a rod of cancellation affects it. A spiritual weapon's AC against touch attacks is 12 (10 + size bonus for Tiny object). If an attacked creature has spell resistance, you make a caster level check (1d20 + caster level) against that spell resistance the first time the spiritual weapon strikes it. If the weapon is successfully resisted, the spell is dispelled. If not, the weapon has its normal full effect on that creature for the duration of the spell. The weapon that you get is often a force replica of your deity's own personal weapon. A cleric without a deity gets a weapon based on his alignment. A neutral cleric without a deity can create a spiritual weapon of any alignment, provided he is acting at least generally in accord with that alignment at the time. The weapons associated with each alignment are as follows: chaos (battleaxe), evil (light flail), good (warhammer), law (longsword)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Stabilize")->setLongDescription(
            "Upon casting this spell, you target a living creature that has -1 or fewer hit points. That creature is automatically stabilized and does not lose any further hit points. If the creature later takes damage, it continues dying normally."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("instantaneous")->setSavingThrow(
                ": Will negates (harmless)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Statue")->setLongDescription(
            "A statue spell turns the subject to solid stone, along with any garments and equipment worn or carried. In statue form, the subject gains hardness 8. The subject retains its own hit points. The subject can see, hear, and smell normally, but it does not need to eat or breathe. Feeling is limited to those sensations that can affect the granite-hard substance of the individual's body. Chipping is equal to a mere scratch, but breaking off one of the statue's arms constitutes serious damage. The subject of a statue spell can return to its normal state, act, and then return instantly to the statue state (a free action) if it so desires as long as the spell duration is in effect."
        )->setCastingTime("1 round")->setComponents(
                "lime, sand, and a drop of water stirred by an iron spike"
            )->setRange("touch")->setTargets("creature touched")->setDuration("1 hour/level (D)")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Status")->setLongDescription(
            "When you need to keep track of comrades who may get separated, status allows you to mentally monitor their relative positions and general condition. You are aware of direction and distance to the creatures and any conditions affecting them: unharmed, wounded, disabled, staggered, unconscious, dying, nauseated, panicked, stunned, poisoned, diseased, confused, or the like. Once the spell has been cast upon the subjects, the distance between them and the caster does not affect the spell as long as they are on the same plane of existence. If a subject leaves the plane, or if it dies, the spell ceases to function for it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one living creature touched per three levels"
            )->setDuration("1 hour/level")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Stinking Cloud")->setLongDescription(
            "Stinking cloud creates a bank of fog like that created by <a href=\"Fog Cloud\">fog cloud</a>, except that the vapors are nauseating. Living creatures in the cloud become nauseated. This condition lasts as long as the creature is in the cloud and for 1d4+1 rounds after it leaves. (Roll separately for each nauseated character.) Any creature that succeeds on its save but remains in the cloud must continue to save each round on your turn. Stinking cloud can be made permanent with a <a href=\"Permanency\">permanency</a> spell. A permanent stinking cloud dispersed by wind reforms in 10 minutes."
        )->setCastingTime("1 standard action")->setComponents("a rotten egg or cabbage leaves")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("Fortitude negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Stone Shape")->setLongDescription(
            "You can form an existing piece of stone into any shape that suits your purpose. While it's possible to make crude coffers, doors, and so forth with stone shape, fine detail isn't possible. There is a 30% chance that any shape including moving parts simply doesn't work."
        )->setCastingTime("1 standard action")->setComponents("soft clay")->setRange("touch")->setTargets(
                "stone or stone object touched, up to 10 cu. ft. + 1 cu. ft./level"
            )->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Stoneskin")->setLongDescription(
            "The warded creature gains resistance to blows, cuts, stabs, and slashes. The subject gains DR 10/adamantine. It ignores the first 10 points of damage each time it takes damage from a weapon, though an adamantine weapon bypasses the reduction. Once the spell has prevented a total of 10 points of damage per caster level (maximum 150 points), it is discharged."
        )->setCastingTime("1 standard action")->setComponents("granite and diamond dust worth 250 gp")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("10 min./level or until discharged")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Stone Tell")->setLongDescription(
            "You gain the ability to speak with stones, which relate to you who or what has touched them as well as revealing what is covered or concealed behind or under them. The stones relate complete descriptions if asked. A stone's perspective, perception, and knowledge may prevent the stone from providing the details you are looking for. You can speak with natural or worked stone."
        )->setCastingTime("10 minutes")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 min./level"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Stone to Flesh")->setLongDescription(
            "This spell restores a petrified creature to its normal state, restoring life and goods. The creature must make a DC 15 Fortitude save to survive the process. Any petrified creature, regardless of size, can be restored. The spell also can convert a mass of stone into a fleshy substance. Such flesh is inert and lacking a vital life force unless a life force or magical energy is available. For example, this spell would turn an animated stone statue into an animated flesh statue, but an ordinary statue would become a mass of inert flesh in the shape of the statue. You can affect an object that fits within a cylinder from 1 foot to 3 feet in diameter and up to 10 feet long or a cylinder of up to those dimensions in a larger mass of stone."
        )->setCastingTime("1 standard action")->setComponents("a drop of blood mixed with earth")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets(
                "one petrified creature or a cylinder of stone from 1 ft. to 3 ft. in diameter and up to 10 ft. long"
            )->setDuration("instantaneous")->setSavingThrow("Fortitude negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Storm of Vengeance")->setLongDescription(
            "You create a huge black storm cloud in the air. Each creature under the cloud must succeed on a Fortitude save or be deafened for 1d4 x 10 minutes. Each round you continue to concentrate, the spell generates additional effects as noted below. Each effect occurs on your turn. 2nd Round: Acid rains down in the area, dealing 1d6 points of acid damage (no save). 3rd Round: You call six bolts of lightning down from the cloud. You decide where the bolts strike. No two bolts may be directed at the same target. Each bolt deals 10d6 points of electricity damage. A creature struck can attempt a Reflex save for half damage. 4th Round: Hailstones rain down in the area, dealing 5d6 points of bludgeoning damage (no save). 5th through 10th Rounds: Violent rain and wind gusts reduce visibility. The rain obscures all sight, including darkvision, beyond 5 feet. A creature 5 feet away has concealment (attacks have a 20% miss chance). Creatures farther away have total concealment (50% miss chance, and the attacker cannot use sight to locate the target). Speed is reduced by three-quarters. Ranged attacks within the area of the storm are impossible. Spells cast within the area are disrupted unless the caster succeeds on a Concentration check against a DC equal to the storm of vengeance's save DC + the level of the spell the caster is trying to cast."
        )->setCastingTime("1 round")->setComponents("")->setRange("long (400 ft. + 40 ft./level)")->setTargets(
                ""
            )->setDuration("concentration (maximum 10 rounds) (D)")->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Suggestion")->setLongDescription(
            "You influence the actions of the target creature by suggesting a course of activity (limited to a sentence or two). The suggestion must be worded in such a manner as to make the activity sound reasonable. Asking the creature to do some obviously harmful act automatically negates the effect of the spell.  The suggested course of activity can continue for the entire duration. If the suggested activity can be completed in a shorter time, the spell ends when the subject finishes what it was asked to do. You can instead specify conditions that will trigger a special activity during the duration. If the condition is not met before the spell duration expires, the activity is not performed. A very reasonable suggestion causes the save to be made with a penalty (such as -1 or -2)."
        )->setCastingTime("1 standard action")->setComponents("a snake's tongue and a honeycomb")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature")->setDuration("1 hour/level or until completed")->setSavingThrow(
                "Will negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Suggestion, Mass")->setLongDescription(
            "This spell functions like <a href=\"Suggestion\">suggestion</a>, except that it can affect more creatures. The same <a href=\"Suggestion\">suggestion</a> applies to all these creatures."
        )->setCastingTime("1 standard action")->setComponents("a snake's tongue and a honeycomb")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("one creature/level, no two of which can be more than 30 ft. apart")->setDuration(
                "1 hour/level or until completed"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Instrument")->setLongDescription(
            "This spell summons one handheld musical instrument of your choice. This instrument appears in your hands or at your feet (your choice). The instrument is typical for its type. Only one instrument appears per casting, and it will play only for you. You can't summon an instrument too large to be held in two hands. The summoned instrument disappears at the end of this spell."
        )->setCastingTime("1 round")->setComponents("")->setRange("0 ft.")->setTargets("")->setDuration(
                "1 min./level (D)"
            )->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 1")->setLongDescription(
            "This spell summons an extraplanar creature (typically an outsider, elemental, or magical beast native to another plane). It appears where you designate and acts immediately, on your turn. It attacks your opponents to the best of its ability. If you can communicate with the creature, you can direct it not to attack, to attack particular enemies, or to perform other actions. The spell conjures one of the creatures from the 1st Level list on Table 10-1. You choose which kind of creature to summon, and you can choose a different one each time you cast the spell. A summoned monster cannot summon or otherwise conjure another creature, nor can it use any teleportation or planar travel abilities. Creatures cannot be summoned into an environment that cannot support them. Creatures summoned using this spell cannot use spells or spell-like abilities that duplicate spells with expensive material components (such as wish). When you use a summoning spell to summon a creature with an alignment or elemental subtype, it is a spell of that type. Creatures on Table 10-1 marked with an are summoned with the celestial template, if you are good, and the fiendish template, if you are evil. If you are neutral, you may choose which template to apply to the creature. Creatures marked with an always have an alignment that matches yours, regardless of their usual alignment. Summoning these creatures makes the summoning spell's type match your alignment. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 2")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 2nd-level list or 1d3 creatures of the same kind from the 1st-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 3")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 3rd-level list, 1d3 creatures of the same kind from the 2nd-level list, or 1d4+1 creatures of the same kind from the 1st-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 4")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 4th-level list, 1d3 creatures of the same kind from the 3rd-level list, or 1d4+1 creatures of the same kind from a lower-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)*</td><td>--</td></tr><tr><td>Dire ape*</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar*</td><td>--</td></tr><tr><td>Dire wolf*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant scorpion*</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp*</td><td>--</td></tr><tr><td>Grizzly bear*</td><td>--</td></tr><tr class=\"alt\"><td>Hell hound</td><td>Evil, Lawful</td></tr><tr><td>Hound archon</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Lion*</td><td>--</td></tr><tr><td>Mephit (any)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)*</td><td>--</td></tr><tr><td>Rhinoceros*</td><td>--</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 5")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 5th-level list, 1d3 creatures of the same kind from the 4th-level list, or 1d4+1 creatures of the same kind from a lower-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)*</td><td>--</td></tr><tr><td>Dire ape*</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar*</td><td>--</td></tr><tr><td>Dire wolf*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant scorpion*</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp*</td><td>--</td></tr><tr><td>Grizzly bear*</td><td>--</td></tr><tr class=\"alt\"><td>Hell hound</td><td>Evil, Lawful</td></tr><tr><td>Hound archon</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Lion*</td><td>--</td></tr><tr><td>Mephit (any)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)*</td><td>--</td></tr><tr><td>Rhinoceros*</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Babau (demon)</td><td>Chaotic, Evil</td></tr><tr><td>Bearded devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Bralani azata</td><td>Chaotic, Good</td></tr><tr><td>Dire lion*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Large)</td><td>Elemental</td></tr><tr><td>Giant moray eel*</td><td>--</td></tr><tr class=\"alt\"><td>Kyton</td><td>Evil, Lawful</td></tr><tr><td>Orca (dolphin)*</td><td>--</td></tr><tr class=\"alt\"><td>Salamander</td><td>Evil</td></tr><tr><td>Woolly rhinoceros*</td><td>--</td></tr><tr class=\"alt\"><td>Xill</td><td>Evil, Lawful</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 6")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except you can summon one creature from the 6th-level list, 1d3 creatures of the same kind from the 5th-level list, or 1d4+1 creatures of the same kind from a lower-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)*</td><td>--</td></tr><tr><td>Dire ape*</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar*</td><td>--</td></tr><tr><td>Dire wolf*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant scorpion*</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp*</td><td>--</td></tr><tr><td>Grizzly bear*</td><td>--</td></tr><tr class=\"alt\"><td>Hell hound</td><td>Evil, Lawful</td></tr><tr><td>Hound archon</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Lion*</td><td>--</td></tr><tr><td>Mephit (any)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)*</td><td>--</td></tr><tr><td>Rhinoceros*</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Babau (demon)</td><td>Chaotic, Evil</td></tr><tr><td>Bearded devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Bralani azata</td><td>Chaotic, Good</td></tr><tr><td>Dire lion*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Large)</td><td>Elemental</td></tr><tr><td>Giant moray eel*</td><td>--</td></tr><tr class=\"alt\"><td>Kyton</td><td>Evil, Lawful</td></tr><tr><td>Orca (dolphin)*</td><td>--</td></tr><tr class=\"alt\"><td>Salamander</td><td>Evil</td></tr><tr><td>Woolly rhinoceros*</td><td>--</td></tr><tr class=\"alt\"><td>Xill</td><td>Evil, Lawful</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Dire bear*</td><td>--</td></tr><tr class=\"alt\"><td>Dire tiger*</td><td>--</td></tr><tr><td>Elasmosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Huge)</td><td>Elemental</td></tr><tr><td>Elephant*</td><td>--</td></tr><tr class=\"alt\"><td>Erinyes (devil)</td><td>Evil, Lawful</td></tr><tr><td>Giant octopus*</td><td>--</td></tr><tr class=\"alt\"><td>Invisible stalker</td><td>Air</td></tr><tr><td>Lillend azata</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Shadow demon</td><td>Chaotic, Evil</td></tr><tr><td>Succubus (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)*</td><td>--</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 7")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 7th-level list, 1d3 creatures of the same kind from the 6th-level list, or 1d4+1 creatures of the same kind from a lower-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)*</td><td>--</td></tr><tr><td>Dire ape*</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar*</td><td>--</td></tr><tr><td>Dire wolf*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant scorpion*</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp*</td><td>--</td></tr><tr><td>Grizzly bear*</td><td>--</td></tr><tr class=\"alt\"><td>Hell hound</td><td>Evil, Lawful</td></tr><tr><td>Hound archon</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Lion*</td><td>--</td></tr><tr><td>Mephit (any)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)*</td><td>--</td></tr><tr><td>Rhinoceros*</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Babau (demon)</td><td>Chaotic, Evil</td></tr><tr><td>Bearded devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Bralani azata</td><td>Chaotic, Good</td></tr><tr><td>Dire lion*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Large)</td><td>Elemental</td></tr><tr><td>Giant moray eel*</td><td>--</td></tr><tr class=\"alt\"><td>Kyton</td><td>Evil, Lawful</td></tr><tr><td>Orca (dolphin)*</td><td>--</td></tr><tr class=\"alt\"><td>Salamander</td><td>Evil</td></tr><tr><td>Woolly rhinoceros*</td><td>--</td></tr><tr class=\"alt\"><td>Xill</td><td>Evil, Lawful</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Dire bear*</td><td>--</td></tr><tr class=\"alt\"><td>Dire tiger*</td><td>--</td></tr><tr><td>Elasmosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Huge)</td><td>Elemental</td></tr><tr><td>Elephant*</td><td>--</td></tr><tr class=\"alt\"><td>Erinyes (devil)</td><td>Evil, Lawful</td></tr><tr><td>Giant octopus*</td><td>--</td></tr><tr class=\"alt\"><td>Invisible stalker</td><td>Air</td></tr><tr><td>Lillend azata</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Shadow demon</td><td>Chaotic, Evil</td></tr><tr><td>Succubus (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)*</td><td>--</td></tr></table> <table><tr><th>7th Level</th><th>Subtype</th></tr><tr><td>Bebelith</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Bone devil</td><td>Evil, Lawful</td></tr><tr><td>Brachiosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Dire crocodile*</td><td>--</td></tr><tr><td>Dire shark*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (greater)</td><td>Elemental</td></tr><tr><td>Giant squid*</td><td>--</td></tr><tr class=\"alt\"><td>Mastadon (elephant)*</td><td>--</td></tr><tr><td>Roc*</td><td>--</td></tr><tr class=\"alt\"><td>Tyrannosaurus (dinosaur)*</td><td>--</td></tr><tr><td>Vrock (demon)</td><td>Chaotic, Evil</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 8")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 8th-level list, 1d3 creatures of the same kind from the 7th-level list, or 1d4+1 creatures of the same kind from a lower-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)*</td><td>--</td></tr><tr><td>Dire ape*</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar*</td><td>--</td></tr><tr><td>Dire wolf*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant scorpion*</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp*</td><td>--</td></tr><tr><td>Grizzly bear*</td><td>--</td></tr><tr class=\"alt\"><td>Hell hound</td><td>Evil, Lawful</td></tr><tr><td>Hound archon</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Lion*</td><td>--</td></tr><tr><td>Mephit (any)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)*</td><td>--</td></tr><tr><td>Rhinoceros*</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Babau (demon)</td><td>Chaotic, Evil</td></tr><tr><td>Bearded devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Bralani azata</td><td>Chaotic, Good</td></tr><tr><td>Dire lion*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Large)</td><td>Elemental</td></tr><tr><td>Giant moray eel*</td><td>--</td></tr><tr class=\"alt\"><td>Kyton</td><td>Evil, Lawful</td></tr><tr><td>Orca (dolphin)*</td><td>--</td></tr><tr class=\"alt\"><td>Salamander</td><td>Evil</td></tr><tr><td>Woolly rhinoceros*</td><td>--</td></tr><tr class=\"alt\"><td>Xill</td><td>Evil, Lawful</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Dire bear*</td><td>--</td></tr><tr class=\"alt\"><td>Dire tiger*</td><td>--</td></tr><tr><td>Elasmosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Huge)</td><td>Elemental</td></tr><tr><td>Elephant*</td><td>--</td></tr><tr class=\"alt\"><td>Erinyes (devil)</td><td>Evil, Lawful</td></tr><tr><td>Giant octopus*</td><td>--</td></tr><tr class=\"alt\"><td>Invisible stalker</td><td>Air</td></tr><tr><td>Lillend azata</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Shadow demon</td><td>Chaotic, Evil</td></tr><tr><td>Succubus (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)*</td><td>--</td></tr></table> <table><tr><th>7th Level</th><th>Subtype</th></tr><tr><td>Bebelith</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Bone devil</td><td>Evil, Lawful</td></tr><tr><td>Brachiosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Dire crocodile*</td><td>--</td></tr><tr><td>Dire shark*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (greater)</td><td>Elemental</td></tr><tr><td>Giant squid*</td><td>--</td></tr><tr class=\"alt\"><td>Mastadon (elephant)*</td><td>--</td></tr><tr><td>Roc*</td><td>--</td></tr><tr class=\"alt\"><td>Tyrannosaurus (dinosaur)*</td><td>--</td></tr><tr><td>Vrock (demon)</td><td>Chaotic, Evil</td></tr></table> <table><tr><th>8th Level</th><th>Subtype</th></tr><tr><td>Barbed devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Elemental (elder)</td><td>Elemental</td></tr><tr><td>Hezrou (demon)</td><td>Chaotic, Evil</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Monster 9")->setLongDescription(
            "This spell functions like <a href=\"Summon Monster I\">summon monster I</a>, except that you can summon one creature from the 9th-level list, 1d3 creatures of the same kind from the 8th-level list, or 1d4+1 creatures of the same kind from a lower-level list. <b>Table: Summon Monster</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat*</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin*</td><td>--</td></tr><tr><td>Eagle*</td><td>--</td></tr><tr class=\"alt\"><td>Fire beetle*</td><td>--</td></tr><tr><td>Poisonous frog*</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)*</td><td>--</td></tr><tr><td>Riding dog*</td><td>--</td></tr><tr class=\"alt\"><td>Viper (snake)*</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant centipede*</td><td>--</td></tr><tr class=\"alt\"><td>Giant frog*</td><td>--</td></tr><tr><td>Giant spider*</td><td>--</td></tr><tr class=\"alt\"><td>Goblin dog*</td><td>--</td></tr><tr><td>Horse*</td><td>--</td></tr><tr class=\"alt\"><td>Hyena*</td><td>--</td></tr><tr><td>Lemure (devil)</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Octopus*</td><td>--</td></tr><tr><td>Squid*</td><td>--</td></tr><tr class=\"alt\"><td>Wolf*</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier*</td><td>--</td></tr><tr class=\"alt\"><td>Ape*</td><td>--</td></tr><tr><td>Aurochs (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Boar*</td><td>--</td></tr><tr><td>Cheetah*</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake*</td><td>--</td></tr><tr><td>Crocodile*</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat*</td><td>--</td></tr><tr><td>Dretch (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Electric eel*</td><td>--</td></tr><tr><td>Giant lizard*</td><td>--</td></tr><tr class=\"alt\"><td>Lantern archon</td><td>Good, Lawful</td></tr><tr><td>Leopard (cat)*</td><td>--</td></tr><tr class=\"alt\"><td>Shark*</td><td>--</td></tr><tr><td>Wolverine*</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)*</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)*</td><td>--</td></tr><tr><td>Dire ape*</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar*</td><td>--</td></tr><tr><td>Dire wolf*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant scorpion*</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp*</td><td>--</td></tr><tr><td>Grizzly bear*</td><td>--</td></tr><tr class=\"alt\"><td>Hell hound</td><td>Evil, Lawful</td></tr><tr><td>Hound archon</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Lion*</td><td>--</td></tr><tr><td>Mephit (any)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)*</td><td>--</td></tr><tr><td>Rhinoceros*</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Babau (demon)</td><td>Chaotic, Evil</td></tr><tr><td>Bearded devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Bralani azata</td><td>Chaotic, Good</td></tr><tr><td>Dire lion*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Large)</td><td>Elemental</td></tr><tr><td>Giant moray eel*</td><td>--</td></tr><tr class=\"alt\"><td>Kyton</td><td>Evil, Lawful</td></tr><tr><td>Orca (dolphin)*</td><td>--</td></tr><tr class=\"alt\"><td>Salamander</td><td>Evil</td></tr><tr><td>Woolly rhinoceros*</td><td>--</td></tr><tr class=\"alt\"><td>Xill</td><td>Evil, Lawful</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Dire bear*</td><td>--</td></tr><tr class=\"alt\"><td>Dire tiger*</td><td>--</td></tr><tr><td>Elasmosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Huge)</td><td>Elemental</td></tr><tr><td>Elephant*</td><td>--</td></tr><tr class=\"alt\"><td>Erinyes (devil)</td><td>Evil, Lawful</td></tr><tr><td>Giant octopus*</td><td>--</td></tr><tr class=\"alt\"><td>Invisible stalker</td><td>Air</td></tr><tr><td>Lillend azata</td><td>Good, Lawful</td></tr><tr class=\"alt\"><td>Shadow demon</td><td>Chaotic, Evil</td></tr><tr><td>Succubus (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)*</td><td>--</td></tr></table> <table><tr><th>7th Level</th><th>Subtype</th></tr><tr><td>Bebelith</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Bone devil</td><td>Evil, Lawful</td></tr><tr><td>Brachiosaurus (dinosaur)*</td><td>--</td></tr><tr class=\"alt\"><td>Dire crocodile*</td><td>--</td></tr><tr><td>Dire shark*</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (greater)</td><td>Elemental</td></tr><tr><td>Giant squid*</td><td>--</td></tr><tr class=\"alt\"><td>Mastadon (elephant)*</td><td>--</td></tr><tr><td>Roc*</td><td>--</td></tr><tr class=\"alt\"><td>Tyrannosaurus (dinosaur)*</td><td>--</td></tr><tr><td>Vrock (demon)</td><td>Chaotic, Evil</td></tr></table> <table><tr><th>8th Level</th><th>Subtype</th></tr><tr><td>Barbed devil</td><td>Evil, Lawful</td></tr><tr class=\"alt\"><td>Elemental (elder)</td><td>Elemental</td></tr><tr><td>Hezrou (demon)</td><td>Chaotic, Evil</td></tr></table> <table><tr><th>9th Level</th><th>Subtype</th></tr><tr><td>Astral Deva (angel)</td><td>Good</td></tr><tr class=\"alt\"><td>Ghaele azata</td><td>Chaotic, Good</td></tr><tr><td>Glabrezu (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Ice devil</td><td>Evil, Lawful</td></tr><tr><td>Nalfeshnee (demon)</td><td>Chaotic, Evil</td></tr><tr class=\"alt\"><td>Trumpet archon</td><td>Good, Lawful</td></tr></table><i>* This creature is summoned with the celestial template if you are good, or the fiendish template if you are evil; you may choose either if you are neutral.</i>"
        )->setCastingTime("1 round")->setComponents("a tiny bag and a small candle")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 1")->setLongDescription(
            "This spell summons to your side a natural creature (typically an animal, fey, magical beast, outsider with the elemental subtype, or a giant). The summoned ally appears where you designate and acts immediately, on your turn. It attacks your opponents to the best of its ability. If you can communicate with the creature, you can direct it not to attack, to attack particular enemies, or to perform other actions as you command. A summoned monster cannot summon or otherwise conjure another creature, nor can it use any teleportation or planar travel abilities. Creatures cannot be summoned into an environment that cannot support them. Creatures summoned using this spell cannot use spells or spell-like abilities that duplicate spells that have expensive material components (such as wish). The spell conjures one of the creatures from the 1st Level list on Table 10-2. You choose which kind of creature to summon, and you can change that choice each time you cast the spell. All the creatures on the table are neutral unless otherwise noted. When you use a summoning spell to summon a creature with an alignment or elemental subtype, it is a spell of that type. All creatures summoned with this spell without alignment subtypes have an alignment that matches yours, regardless of their usual alignment. Summoning these creatures makes the summoning spell's type match your alignment.  <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 2")->setLongDescription(
            "This spell functions as <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you summon one 2nd-level creature or 1d3 1st-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 3")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 3rd-level creature, 1d3 2nd-level creatures of the same kind, or 1d4+1 1st-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 4")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 4th-level creature, 1d3 3rd-level creatures of the same kind, or 1d4+1 lower-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)</td><td>--</td></tr><tr><td>Dire ape</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar</td><td>--</td></tr><tr><td>Dire wolf</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant stag beetle</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp</td><td>--</td></tr><tr><td>Griffon</td><td>--</td></tr><tr class=\"alt\"><td>Grizzly bear</td><td>--</td></tr><tr><td>Lion</td><td>--</td></tr><tr class=\"alt\"><td>Mephit (any)</td><td>Elemental</td></tr><tr><td>Owlbear</td><td>--</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)</td><td>--</td></tr><tr><td>Rhinoceros</td><td>--</td></tr><tr class=\"alt\"><td>Satyr</td><td>--</td></tr><tr><td>Tiger</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 5")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 5th-level creature, 1d3 4th-level creatures of the same kind, or 1d4+1 lower-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)</td><td>--</td></tr><tr><td>Dire ape</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar</td><td>--</td></tr><tr><td>Dire wolf</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant stag beetle</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp</td><td>--</td></tr><tr><td>Griffon</td><td>--</td></tr><tr class=\"alt\"><td>Grizzly bear</td><td>--</td></tr><tr><td>Lion</td><td>--</td></tr><tr class=\"alt\"><td>Mephit (any)</td><td>Elemental</td></tr><tr><td>Owlbear</td><td>--</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)</td><td>--</td></tr><tr><td>Rhinoceros</td><td>--</td></tr><tr class=\"alt\"><td>Satyr</td><td>--</td></tr><tr><td>Tiger</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Cyclops</td><td>--</td></tr><tr><td>Dire lion</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin (orca)</td><td>--</td></tr><tr><td>Elemental (Large)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Ettin</td><td>--</td></tr><tr><td>Giant moray eel</td><td>--</td></tr><tr class=\"alt\"><td>Girallon</td><td>--</td></tr><tr><td>Manticore</td><td>--</td></tr><tr class=\"alt\"><td>Woolly rhinoceros</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 6")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 6th-level creature, 1d3 5th-level creatures of the same kind, or 1d4+1 lower-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)</td><td>--</td></tr><tr><td>Dire ape</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar</td><td>--</td></tr><tr><td>Dire wolf</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant stag beetle</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp</td><td>--</td></tr><tr><td>Griffon</td><td>--</td></tr><tr class=\"alt\"><td>Grizzly bear</td><td>--</td></tr><tr><td>Lion</td><td>--</td></tr><tr class=\"alt\"><td>Mephit (any)</td><td>Elemental</td></tr><tr><td>Owlbear</td><td>--</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)</td><td>--</td></tr><tr><td>Rhinoceros</td><td>--</td></tr><tr class=\"alt\"><td>Satyr</td><td>--</td></tr><tr><td>Tiger</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Cyclops</td><td>--</td></tr><tr><td>Dire lion</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin (orca)</td><td>--</td></tr><tr><td>Elemental (Large)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Ettin</td><td>--</td></tr><tr><td>Giant moray eel</td><td>--</td></tr><tr class=\"alt\"><td>Girallon</td><td>--</td></tr><tr><td>Manticore</td><td>--</td></tr><tr class=\"alt\"><td>Woolly rhinoceros</td><td>--</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Bulette</td><td>--</td></tr><tr class=\"alt\"><td>Dire bear</td><td>--</td></tr><tr><td>Dire tiger</td><td>--</td></tr><tr class=\"alt\"><td>Elasmosaurus (dinosaur)</td><td>--</td></tr><tr><td>Elemental (Huge)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Elephant</td><td>--</td></tr><tr><td>Giant octopus</td><td>--</td></tr><tr class=\"alt\"><td>Giant scorpion</td><td>--</td></tr><tr><td>Hill giant</td><td>--</td></tr><tr class=\"alt\"><td>Stegosaurus (dinosaur)</td><td>--</td></tr><tr><td>Stone giant</td><td>Earth</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 7")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 7th-level creature, 1d3 6th-level creatures of the same kind, or 1d4+1 lower-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)</td><td>--</td></tr><tr><td>Dire ape</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar</td><td>--</td></tr><tr><td>Dire wolf</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant stag beetle</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp</td><td>--</td></tr><tr><td>Griffon</td><td>--</td></tr><tr class=\"alt\"><td>Grizzly bear</td><td>--</td></tr><tr><td>Lion</td><td>--</td></tr><tr class=\"alt\"><td>Mephit (any)</td><td>Elemental</td></tr><tr><td>Owlbear</td><td>--</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)</td><td>--</td></tr><tr><td>Rhinoceros</td><td>--</td></tr><tr class=\"alt\"><td>Satyr</td><td>--</td></tr><tr><td>Tiger</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Cyclops</td><td>--</td></tr><tr><td>Dire lion</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin (orca)</td><td>--</td></tr><tr><td>Elemental (Large)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Ettin</td><td>--</td></tr><tr><td>Giant moray eel</td><td>--</td></tr><tr class=\"alt\"><td>Girallon</td><td>--</td></tr><tr><td>Manticore</td><td>--</td></tr><tr class=\"alt\"><td>Woolly rhinoceros</td><td>--</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Bulette</td><td>--</td></tr><tr class=\"alt\"><td>Dire bear</td><td>--</td></tr><tr><td>Dire tiger</td><td>--</td></tr><tr class=\"alt\"><td>Elasmosaurus (dinosaur)</td><td>--</td></tr><tr><td>Elemental (Huge)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Elephant</td><td>--</td></tr><tr><td>Giant octopus</td><td>--</td></tr><tr class=\"alt\"><td>Giant scorpion</td><td>--</td></tr><tr><td>Hill giant</td><td>--</td></tr><tr class=\"alt\"><td>Stegosaurus (dinosaur)</td><td>--</td></tr><tr><td>Stone giant</td><td>Earth</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)</td><td>--</td></tr></table> <table><tr><th>7th Level</th><th>Subtype</th></tr><tr><td>Brachiosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Dire crocodile</td><td>--</td></tr><tr><td>Dire shark</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (greater)</td><td>Elemental</td></tr><tr><td>Fire giant</td><td>Fire</td></tr><tr class=\"alt\"><td>Frost giant</td><td>Cold</td></tr><tr><td>Giant squid</td><td>--</td></tr><tr class=\"alt\"><td>Mastadon (elephant)</td><td>--</td></tr><tr><td>Roc</td><td>--</td></tr><tr class=\"alt\"><td>Tyrannosaurus (dinosaur)</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 8")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 8th-level creature, 1d3 7th-level creatures of the same kind, or 1d4+1 lower-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)</td><td>--</td></tr><tr><td>Dire ape</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar</td><td>--</td></tr><tr><td>Dire wolf</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant stag beetle</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp</td><td>--</td></tr><tr><td>Griffon</td><td>--</td></tr><tr class=\"alt\"><td>Grizzly bear</td><td>--</td></tr><tr><td>Lion</td><td>--</td></tr><tr class=\"alt\"><td>Mephit (any)</td><td>Elemental</td></tr><tr><td>Owlbear</td><td>--</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)</td><td>--</td></tr><tr><td>Rhinoceros</td><td>--</td></tr><tr class=\"alt\"><td>Satyr</td><td>--</td></tr><tr><td>Tiger</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Cyclops</td><td>--</td></tr><tr><td>Dire lion</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin (orca)</td><td>--</td></tr><tr><td>Elemental (Large)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Ettin</td><td>--</td></tr><tr><td>Giant moray eel</td><td>--</td></tr><tr class=\"alt\"><td>Girallon</td><td>--</td></tr><tr><td>Manticore</td><td>--</td></tr><tr class=\"alt\"><td>Woolly rhinoceros</td><td>--</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Bulette</td><td>--</td></tr><tr class=\"alt\"><td>Dire bear</td><td>--</td></tr><tr><td>Dire tiger</td><td>--</td></tr><tr class=\"alt\"><td>Elasmosaurus (dinosaur)</td><td>--</td></tr><tr><td>Elemental (Huge)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Elephant</td><td>--</td></tr><tr><td>Giant octopus</td><td>--</td></tr><tr class=\"alt\"><td>Giant scorpion</td><td>--</td></tr><tr><td>Hill giant</td><td>--</td></tr><tr class=\"alt\"><td>Stegosaurus (dinosaur)</td><td>--</td></tr><tr><td>Stone giant</td><td>Earth</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)</td><td>--</td></tr></table> <table><tr><th>7th Level</th><th>Subtype</th></tr><tr><td>Brachiosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Dire crocodile</td><td>--</td></tr><tr><td>Dire shark</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (greater)</td><td>Elemental</td></tr><tr><td>Fire giant</td><td>Fire</td></tr><tr class=\"alt\"><td>Frost giant</td><td>Cold</td></tr><tr><td>Giant squid</td><td>--</td></tr><tr class=\"alt\"><td>Mastadon (elephant)</td><td>--</td></tr><tr><td>Roc</td><td>--</td></tr><tr class=\"alt\"><td>Tyrannosaurus (dinosaur)</td><td>--</td></tr></table> <table><tr><th>8th Level</th><th>Subtype</th></tr><tr><td>Cloud giant</td><td>Air</td></tr><tr class=\"alt\"><td>Elemental (elder)</td><td>Elemental</td></tr><tr><td>Purple worm</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Nature's Ally 9")->setLongDescription(
            "This spell functions like <a href=\"Summon Nature's Ally I\">summon nature's ally I</a>, except that you can summon one 9th-level creature, 1d3 8th-level creatures of the same kind, or 1d4+1 lower-level creatures of the same kind. <b>Table: Summon Nature's Ally</b><table><tr><th>1st Level</th><th>Subtype</th></tr><tr><td>Dire rat</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin</td><td>--</td></tr><tr><td>Eagle</td><td>--</td></tr><tr class=\"alt\"><td>Giant centipede</td><td>--</td></tr><tr><td>Fire beetle</td><td>--</td></tr><tr class=\"alt\"><td>Mite (gremlin)</td><td>--</td></tr><tr><td>Poisonous frog</td><td>--</td></tr><tr class=\"alt\"><td>Pony (horse)</td><td>--</td></tr><tr><td>Riding dog</td><td>--</td></tr><tr class=\"alt\"><td>Stirge</td><td>--</td></tr><tr><td>Viper (snake)</td><td>--</td></tr></table> <table><tr><th>2nd Level</th><th>Subtype</th></tr><tr><td>Ant, drone</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Small)</td><td>Elemental</td></tr><tr><td>Giant frog</td><td>--</td></tr><tr class=\"alt\"><td>Giant spider</td><td>--</td></tr><tr><td>Goblin Dog</td><td>--</td></tr><tr class=\"alt\"><td>Horse</td><td>--</td></tr><tr><td>Hyena</td><td>--</td></tr><tr class=\"alt\"><td>Octopus</td><td>--</td></tr><tr><td>Squid</td><td>--</td></tr><tr class=\"alt\"><td>Wolf</td><td>--</td></tr></table> <table><tr><th>3rd Level</th><th>Subtype</th></tr><tr><td>Ant, soldier</td><td>--</td></tr><tr class=\"alt\"><td>Ape</td><td>--</td></tr><tr><td>Aurochs (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Boar</td><td>--</td></tr><tr><td>Cheetah</td><td>--</td></tr><tr class=\"alt\"><td>Constrictor snake</td><td>--</td></tr><tr><td>Crocodile</td><td>--</td></tr><tr class=\"alt\"><td>Dire bat</td><td>--</td></tr><tr><td>Electric Eel</td><td>--</td></tr><tr class=\"alt\"><td>Giant crab</td><td>--</td></tr><tr><td>Giant lizard</td><td>--</td></tr><tr class=\"alt\"><td>Leopard (cat)</td><td>--</td></tr><tr><td>Shark</td><td>--</td></tr><tr class=\"alt\"><td>Wolverine</td><td>--</td></tr></table> <table><tr><th>4th Level</th><th>Subtype</th></tr><tr><td>Bison (herd animal)</td><td>--</td></tr><tr class=\"alt\"><td>Deinonychus (dinosaur)</td><td>--</td></tr><tr><td>Dire ape</td><td>--</td></tr><tr class=\"alt\"><td>Dire boar</td><td>--</td></tr><tr><td>Dire wolf</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (Medium)</td><td>Elemental</td></tr><tr><td>Giant stag beetle</td><td>--</td></tr><tr class=\"alt\"><td>Giant wasp</td><td>--</td></tr><tr><td>Griffon</td><td>--</td></tr><tr class=\"alt\"><td>Grizzly bear</td><td>--</td></tr><tr><td>Lion</td><td>--</td></tr><tr class=\"alt\"><td>Mephit (any)</td><td>Elemental</td></tr><tr><td>Owlbear</td><td>--</td></tr><tr class=\"alt\"><td>Pteranodon (dinosaur)</td><td>--</td></tr><tr><td>Rhinoceros</td><td>--</td></tr><tr class=\"alt\"><td>Satyr</td><td>--</td></tr><tr><td>Tiger</td><td>--</td></tr></table> <table><tr><th>5th Level</th><th>Subtype</th></tr><tr><td>Ankylosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Cyclops</td><td>--</td></tr><tr><td>Dire lion</td><td>--</td></tr><tr class=\"alt\"><td>Dolphin (orca)</td><td>--</td></tr><tr><td>Elemental (Large)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Ettin</td><td>--</td></tr><tr><td>Giant moray eel</td><td>--</td></tr><tr class=\"alt\"><td>Girallon</td><td>--</td></tr><tr><td>Manticore</td><td>--</td></tr><tr class=\"alt\"><td>Woolly rhinoceros</td><td>--</td></tr></table> <table><tr><th>6th Level</th><th>Subtype</th></tr><tr><td>Bulette</td><td>--</td></tr><tr class=\"alt\"><td>Dire bear</td><td>--</td></tr><tr><td>Dire tiger</td><td>--</td></tr><tr class=\"alt\"><td>Elasmosaurus (dinosaur)</td><td>--</td></tr><tr><td>Elemental (Huge)</td><td>Elemental</td></tr><tr class=\"alt\"><td>Elephant</td><td>--</td></tr><tr><td>Giant octopus</td><td>--</td></tr><tr class=\"alt\"><td>Giant scorpion</td><td>--</td></tr><tr><td>Hill giant</td><td>--</td></tr><tr class=\"alt\"><td>Stegosaurus (dinosaur)</td><td>--</td></tr><tr><td>Stone giant</td><td>Earth</td></tr><tr class=\"alt\"><td>Triceratops (dinosaur)</td><td>--</td></tr></table> <table><tr><th>7th Level</th><th>Subtype</th></tr><tr><td>Brachiosaurus (dinosaur)</td><td>--</td></tr><tr class=\"alt\"><td>Dire crocodile</td><td>--</td></tr><tr><td>Dire shark</td><td>--</td></tr><tr class=\"alt\"><td>Elemental (greater)</td><td>Elemental</td></tr><tr><td>Fire giant</td><td>Fire</td></tr><tr class=\"alt\"><td>Frost giant</td><td>Cold</td></tr><tr><td>Giant squid</td><td>--</td></tr><tr class=\"alt\"><td>Mastadon (elephant)</td><td>--</td></tr><tr><td>Roc</td><td>--</td></tr><tr class=\"alt\"><td>Tyrannosaurus (dinosaur)</td><td>--</td></tr></table> <table><tr><th>8th Level</th><th>Subtype</th></tr><tr><td>Cloud giant</td><td>Air</td></tr><tr class=\"alt\"><td>Elemental (elder)</td><td>Elemental</td></tr><tr><td>Purple worm</td><td>--</td></tr></table> <table><tr><th>9th Level</th><th>Subtype</th></tr><tr><td>Pixie (w/irresistible dance and sleep arrows)</td><td>--</td></tr><tr class=\"alt\"><td>Storm giant</td><td>--</td></tr></table>"
        )->setCastingTime("1 round")->setComponents("")->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets(
                ""
            )->setDuration("1 round/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Summon Swarm")->setLongDescription(
            "You summon a swarm of bats, rats, or spiders (your choice), which attacks all other creatures within its area. (You may summon the swarm so that it shares the area of other creatures.) If no living creatures are within its area, the swarm attacks or pursues the nearest creature as best it can. The caster has no control over its target or direction of travel."
        )->setCastingTime("1 round")->setComponents("a square of red cloth")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("concentration + 2 rounds")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sunbeam")->setLongDescription(
            "For the duration of this spell, you can use a standard action to evoke a dazzling beam of intense light each round. You can call forth one beam per three caster levels (maximum six beams at 18th level). The spell ends when its duration runs out or your allotment of beams is exhausted. Each creature in the beam is blinded and takes 4d6 points of damage. Any creatures to which sunlight is harmful or unnatural take double damage. A successful Reflex save negates the blindness and reduces the damage by half. An undead creature caught within the beam takes 1d6 points of damage per caster level (maximum 20d6), or half damage if a Reflex save is successful. In addition, the beam results in the <a href=\"Destruction\">destruction</a> of any undead creature specifically harmed by bright light if it fails its save. The ultraviolet light generated by the spell deals damage to fungi, mold, oozes, and slimes just as if they were undead creatures."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "1 round/level or until all beams are exhausted"
            )->setSavingThrow("Reflex negates and Reflex half")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sunburst")->setLongDescription(
            "Sunburst causes a globe of searing radiance to explode silently from a point you select. All creatures in the globe are blinded and take 6d6 points of damage. A creature to which sunlight is harmful or unnatural takes double damage. A successful Reflex save negates the blindness and reduces the damage by half. An undead creature caught within the globe takes 1d6 points of damage per caster level (maximum 25d6), or half damage if a Reflex save is successful. In addition, the burst results in the <a href=\"Destruction\">destruction</a> of any undead creature specifically harmed by bright light if it fails its save. The ultraviolet light generated by the spell deals damage to fungi, mold, oozes, and slimes just as if they were undead creatures. Sunburst dispels any darkness spells of lower than 9th level within its area."
        )->setCastingTime("1 standard action")->setComponents("sunstone and fire source")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("Reflex partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Death")->setLongDescription(
            "This spell allows you to scribe a potent rune of power upon a surface. When triggered, a symbol of death kills one or more creatures within 60 feet of the symbol (treat as a burst) whose combined total current hit points do not exceed 150. The symbol of death affects the closest creatures first, skipping creatures with too many hit points to affect. Once triggered, the symbol becomes active and glows, lasting for 10 minutes per caster level or until it has affected 150 hit points' worth of creatures, whichever comes first. A creature that enters the area while the symbol of death is active is subject to its effect, whether or not that creature was in the area when it was triggered. A creature need save against the symbol only once as long as it remains within the area, though if it leaves the area and returns while the symbol is still active, it must save again. Until it is triggered, the symbol of death is inactive (though visible and legible at a distance of 60 feet). To be effective, a symbol of death must always be placed in plain sight and in a prominent location. Covering or hiding the rune renders the symbol of death ineffective, unless a creature removes the covering, in which case the symbol of death works normally. As a default, a symbol of death is triggered whenever a creature does one or more of the following, as you select: looks at the rune; reads the rune; touches the rune; passes over the rune; or passes through a portal bearing the rune. Regardless of the trigger method or methods chosen, a creature more than 60 feet from a symbol of death can't trigger it (even if it meets one or more of the triggering conditions, such as reading the rune). Once the spell is cast, a symbol of death's triggering conditions cannot be changed. In this case, reading the rune means any attempt to study it, identify it, or fathom its meaning. Throwing a cover over a symbol of death to render it inoperative triggers it if the symbol reacts to touch. You can't use a symbol of death offensively; for instance, a touch-triggered symbol of death remains untriggered if an item bearing the symbol of death is used to touch a creature. Likewise, a symbol of death cannot be placed on a weapon and set to activate when the weapon strikes a foe. You can also set special triggering limitations of your own. These can be as simple or elaborate as you desire. Special conditions for triggering a symbol of death can be based on a creature's name, identity, or alignment, but otherwise must be based on observable actions or qualities. Intangibles such as level, class, HD, and hit points don't qualify.  When scribing a symbol of death, you can specify a password or phrase that prevents a creature using it from triggering the symbol's effect. Anyone using the password remains immune to that particular rune's effects so long as the creature remains within 60 feet of the rune. If the creature leaves the radius and returns later, it must use the password again. You also can attune any number of creatures to the symbol of death, but doing this can extend the casting time. Attuning one or two creatures takes negligible time, and attuning a small group (as many as 10 creatures) extends the casting time to 1 hour. Attuning a large group (as many as 25 creatures) takes 24 hours. Attuning larger groups takes an additional 24 hours per 25 creatures. Any creature attuned to a symbol of death cannot trigger it and is immune to its effects, even if within its radius when it is triggered. You are automatically considered attuned to your own symbols of death, and thus always ignore the effects and cannot inadvertently trigger them. Read magic allows you to identify a symbol with a Spellcraft check (DC 10 + the symbol's spell level). Of course, if the symbol is set to be triggered by reading it, this will trigger the symbol. A symbol of death can be removed by a successful <a href=\"Dispel Magic\">dispel magic</a> targeted solely on the rune. An <a href=\"Erase\">erase</a> spell has no effect on a symbol of death. Destruction of the surface where a symbol of death is inscribed destroys the symbol but also triggers it. Symbol of death can be made permanent with a <a href=\"Permanency\">permanency</a> spell. A permanent symbol of death that is disabled or has affected its maximum number of hit points becomes inactive for 10 minutes, but then can be triggered again as normal. Note: Magic traps such as symbol of death are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of death and Disable Device to thwart it. The DC in each case is 25 + spell level, or 33 for symbol of death."
        )->setCastingTime("10 minutes")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth 5,000 gp each"
            )->setRange("0 ft.; see text")->setTargets("")->setDuration("see text")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Fear")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that all creatures within 60 feet of the symbol of fear instead become panicked for 1 round per caster level. Note: Magic traps such as symbol of fear are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of fear and Disable Device to thwart it. The DC in each case is 25 + spell level, or 31 for symbol of fear."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 1,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Insanity")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that all creatures within the radius of the symbol of insanity instead become permanently insane (as the <a href=\"Insanity\">insanity</a> spell). Unlike <a href=\"Symbol of Death\">symbol of death</a>, symbol of insanity has no hit point limit; once triggered, a symbol of insanity simply remains active for 10 minutes per caster level. Note: Magic traps such as symbol of insanity are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of insanity and Disable Device to thwart it. The DC in each case is 25 + spell level, or 33 for symbol of insanity."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 5,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Pain")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that each creature within the radius of a symbol of pain instead suffers wracking pains that impose a -4 penalty on attack rolls, skill checks, and ability checks. These effects last for 1 hour after the creature moves farther than 60 feet from the symbol. Unlike <a href=\"Symbol of Death\">symbol of death</a>, symbol of pain has no hit point limit; once triggered, a symbol of pain simply remains active for 10 minutes per caster level. Note: Magic traps such as symbol of pain are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of pain and Disable Device to thwart it. The DC in each case is 25 + spell level, or 30 for symbol of pain."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 1,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Persuasion")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that all creatures within the radius of a symbol of persuasion instead become charmed by the caster (as the <a href=\"Charm Monster\">charm monster</a> spell) for 1 hour per caster level. Unlike <a href=\"Symbol of Death\">symbol of death</a>, symbol of persuasion has no hit point limit; once triggered, a symbol of persuasion simply remains active for 10 minutes per caster level. Note: Magic traps such as symbol of persuasion are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of persuasion and Disable Device to thwart it. The DC in each case is 25 + spell level, or 31 for symbol of persuasion."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 5,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Sleep")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that all creatures of 10 HD or less within 60 feet of the symbol of sleep instead fall into a catatonic slumber for 3d6 x 10 minutes. Unlike with the sleep spell, sleeping creatures cannot be awakened by nonmagical means before this time expires. Unlike <a href=\"Symbol of Death\">symbol of death</a>, symbol of sleep has no hit point limit; once triggered, a symbol of sleep simply remains active for 10 minutes per caster level. Note: Magic traps such as symbol of sleep are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of sleep and Disable Device to thwart it. The DC in each case is 25 + spell level, or 30 for symbol of sleep."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 1,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Stunning")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that all creatures within 60 feet of a symbol of stunning instead become stunned for 1d6 rounds. Note: Magic traps such as symbol of stunning are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of stunning and Disable Device to thwart it. The DC in each case is 25 + spell level, or 32 for symbol of stunning."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 5,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Symbol of Weakness")->setLongDescription(
            "This spell functions like <a href=\"Symbol of Death\">symbol of death</a>, except that every creature within 60 feet of a symbol of weakness instead suffers crippling weakness that deals 3d6 points of Strength damage. Unlike <a href=\"Symbol of Death\">symbol of death</a>, symbol of weakness has no hit point limit; once triggered, a symbol of weakness simply remains active for 10 minutes per caster level. A creature can only be affected by this symbol once. Note: Magic traps such as symbol of weakness are hard to detect and disable. A rogue (only) can use the Perception skill to find a symbol of weakness and Disable Device to thwart it. The DC in each case is 25 + spell level, or 32 for symbol of weakness."
        )->setCastingTime("")->setComponents(
                "mercury and phosphorus, plus powdered diamond and opal worth a total of 5,000 gp"
            )->setRange("")->setTargets("")->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sympathetic Vibration")->setLongDescription(
            "By attuning yourself to a freestanding structure, you can create a damaging vibration within it. Once it begins, the vibration deals 2d10 points of damage per round to the target structure, bypassing hardness. You can choose at the time of casting to limit the duration of the spell; otherwise it lasts for 1 round per level. If the spell is cast upon a target that is not freestanding, the surrounding stone dissipates the effect and no damage occurs. Sympathetic vibration cannot affect creatures (including constructs). Since a structure is an unattended object, it gets no saving throw to resist the effect."
        )->setCastingTime("10 minutes")->setComponents("a tuning fork")->setRange("touch")->setTargets(
                "one freestanding structure"
            )->setDuration("up to 1 round/level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Sympathy")->setLongDescription(
            "You cause an object or location to emanate magical vibrations that attract either a specific kind of intelligent creature or creatures of a particular alignment, as defined by you. The particular kind of creature to be affected must be named specifically. A creature subtype is not specific enough. Likewise, the specific alignment must be named. Creatures of the specified kind or alignment feel elated and pleased to be in the area or desire to touch or possess the object. The compulsion to stay in the area or touch the object is overpowering. If the save is successful, the creature is released from the enchantment, but a subsequent save must be made 1d6 x 10 minutes later. If this save fails, the affected creature attempts to return to the area or object. Sympathy counters and dispels <a href=\"Antipathy\">antipathy</a>."
        )->setCastingTime("1 hour")->setComponents("a drop of honey and crushed pearls worth 1,500 gp")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one location (up to a 10-ft. cube/level) or one object")->setDuration(
                "2 hours/level (D)"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Telekinesis")->setLongDescription(
            "You move objects or creatures by concentrating on them. Depending on the version selected, the spell can provide a gentle, sustained force, perform a variety of combat maneuvers, or exert a single short, violent thrust. Sustained Force: A sustained force moves an object weighing no more than 25 pounds per caster level (maximum 375 pounds at 15th level) up to 20 feet per round. A creature can negate the effect on an object it possesses with a successful Will save or with spell resistance. This version of the spell can last 1 round per caster level, but it ends if you cease concentration. The weight can be moved vertically, horizontally, or in both directions. An object cannot be moved beyond your range. The spell ends if the object is forced beyond the range. If you cease concentration for any reason, the object falls or stops. An object can be telekinetically manipulated as if with one hand. For example, a lever or rope can be pulled, a key can be turned, an object rotated, and so on, if the force required is within the weight limitation. You might even be able to untie simple knots, though delicate activities such as these require DC 15 Intelligence checks. Combat Maneuver: Alternatively, once per round, you can use telekinesis to perform a bull rush, disarm, grapple (including pin), or trip. Resolve these attempts as normal, except that they don't provoke attacks of opportunity, you use your caster level in place of your Combat Maneuver Bonus, and you add your Intelligence modifier (if a wizard) or Charisma modifier (if a sorcerer) in place of your Strength or Dexterity modifier. No save is allowed against these attempts, but spell resistance applies normally. This version of the spell can last 1 round per caster level, but it ends if you cease concentration. Violent Thrust: Alternatively, the spell energy can be spent in a single round. You can hurl one object or creature per caster level (maximum 15) that are within range and all within 10 feet of each other toward any target within 10 feet per level of all the objects. You can hurl up to a total weight of 25 pounds per caster level (maximum 375 pounds at 15th level). You must succeed on attack rolls (one per creature or object thrown) to hit the target with the items, using your base attack bonus + your Intelligence modifier (if a wizard) or Charisma modifier (if a sorcerer). Weapons cause standard damage (with no Strength bonus; note that arrows or bolts deal damage as daggers of their size when used in this manner). Other objects cause damage ranging from 1 point per 25 pounds (for less dangerous objects) to 1d6 points of damage per 25 pounds (for hard, dense objects). Objects and creatures that miss their target land in a square adjacent to the target. Creatures who fall within the weight capacity of the spell can be hurled, but they are allowed Will saves (and spell resistance) to negate the effect, as are those whose held possessions are targeted by the spell. If a telekinesed creature is hurled against a solid surface, it takes damage as if it had fallen 10 feet (1d6 points)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("see text")->setDuration(
                "concentration (up to 1 round/level) or instantaneous; see text"
            )->setSavingThrow("Will negates (object) or none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Telekinetic Sphere")->setLongDescription(
            "This spell functions like <a href=\"Resilient Sphere\">resilient sphere</a>, but the creatures or objects caught inside the globe created by the spell are made nearly weightless. Anything contained within a telekinetic sphere weighs only one-sixteenth of its normal weight. You can telekinetically lift anything in the sphere that normally weighs 5,000 pounds or less. The telekinetic control extends from you out to medium range (100 feet + 10 feet per caster level) after the sphere has succeeded in encapsulating its contents. You can move the sphere, along with the objects and creatures it contains that weigh a total of 5,000 pounds or less, by concentrating on the sphere. You can begin moving a sphere in the round after casting the spell. If you concentrate on doing so (a standard action), you can move the sphere as much as 30 feet in a round. If you cease concentrating, the sphere does not move in that round (if on a level surface) or descends at its falling rate (if aloft) until it reaches a level surface. You can resume concentrating on your next turn or any later turn during the spell's duration. The sphere falls at a rate of only 60 feet per round, which is not fast enough to cause damage to the contents of the sphere. You can move the sphere telekinetically even if you are in it."
        )->setCastingTime("1 standard action")->setComponents("a crystal sphere and a pair of small magnets")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow(
                "Reflex negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Telepathic Bond")->setLongDescription(
            "You forge a telepathic bond among yourself and a number of willing creatures, each of which must have an Intelligence score of 3 or higher. Each creature included in the link is linked to all the others. The creatures can communicate telepathically through the bond regardless of language. No special power or influence is established as a result of the bond. Once the bond is formed, it works over any distance (although not from one plane to another). If desired, you may leave yourself out of the telepathic bond forged. This decision must be made at the time of casting. Telepathic bond can be made permanent with a <a href=\"Permanency\">permanency</a> spell, though it only bonds two creatures per casting of <a href=\"Permanency\">permanency</a>."
        )->setCastingTime("1 standard action")->setComponents("two eggshells from two different creatures")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets(
                "you plus one willing creature per three levels, no two of which can be more than 30 ft. apart"
            )->setDuration("10 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Teleport")->setLongDescription(
            "This spell instantly transports you to a designated destination, which may be as distant as 100 miles per caster level. Interplanar travel is not possible. You can bring along objects as long as their weight doesn't exceed your maximum load. You may also bring one additional willing Medium or smaller creature (carrying gear or objects up to its maximum load) or its equivalent per three caster levels. A Large creature counts as two Medium creatures, a Huge creature counts as four Medium creatures, and so forth. All creatures to be transported must be in contact with one another, and at least one of those creatures must be in contact with you. As with all spells where the range is personal and the target is you, you need not make a saving throw, nor is spell resistance applicable to you. Only objects held or in use (attended) by another person receive saving throws and spell resistance. You must have some clear idea of the location and layout of the destination. The clearer your mental image, the more likely the teleportation works. Areas of strong physical or magical energy may make teleportation more hazardous or even impossible. To see how well the teleportation works, roll d% and consult the table at the end of this spell. Refer to the following information for definitions of the terms on the table. Familiarity: Very familiar is a place where you have been very often and where you feel at home. Studied carefully is a place you know well, either because you can currently physically see it or you've been there often. Seen casually is a place that you have seen more than once but with which you are not very familiar. Viewed once is a place that you have seen once, possibly using magic such as <a href=\"Scrying\">scrying</a>.  False destination is a place that does not truly exist or if you are teleporting to an otherwise familiar location that no longer exists as such or has been so completely altered as to no longer be familiar to you. When traveling to a false destination, roll 1d20+80 to obtain results on the table, rather than rolling d%, since there is no real destination for you to hope to arrive at or even be off target from. On Target: You appear where you want to be. Off Target: You appear safely a random distance away from the destination in a random direction. Distance off target is d% of the distance that was to be traveled. The direction off target is determined randomly. Similar Area: You wind up in an area that's visually or thematically similar to the target area. Generally, you appear in the closest similar place within range. If no such area exists within the spell's range, the spell simply fails instead. Mishap: You and anyone else teleporting with you have gotten scrambled. You each take 1d10 points of damage, and you reroll on the chart to see where you wind up. For these rerolls, roll 1d20+80. Each time Mishap comes up, the characters take more damage and must reroll. <table><tr><th>Familiarity</th><th>On Target</th><th>Off Target</th><th>Similar Area</th><th>Mishap</th></tr><tr><td>Very familiar</td><td>01-97</td><td>98-99</td><td>100</td><td>--</td></tr><tr class=\"alt\"><td>Studied carefully</td><td>01-94</td><td>95-97</td><td>98-99</td><td>100</td></tr><tr><td>Seen casually</td><td>01-88</td><td>89-94</td><td>95-98</td><td>99-100</td></tr><tr class=\"alt\"><td>Viewed once</td><td>01-76</td><td>77-88</td><td>89-96</td><td>97-100</td></tr><tr><td>False destination</td><td>--</td><td>--</td><td>81-92</td><td>93-100</td></tr></table>"
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal and touch")->setTargets(
                "you and touched objects or other touched willing creatures"
            )->setDuration("instantaneous")->setSavingThrow("none and Will negates (object)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Teleport, Greater")->setLongDescription(
            "This spell functions like <a href=\"Teleport\">teleport</a>, except that there is no range limit and there is no chance you arrive off target. In addition, you need not have seen the destination, but in that case you must have at least a reliable description of the place to which you are teleporting. If you attempt to teleport with insufficient information (or with misleading information), you disappear and simply reappear in your original location. Interplanar travel is not possible."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal and touch")->setTargets(
                "you and touched objects or other touched willing creatures"
            )->setDuration("instantaneous")->setSavingThrow("none and Will negates (object)")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Teleportation Circle")->setLongDescription(
            "You create a circle on the floor or other horizontal surface that teleports, as <a href=\"Teleport, Greater\">greater teleport</a>, any creature who stands on it to a designated spot. Once you designate the destination for the circle, you can't change it. The spell fails if you attempt to set the circle to teleport creatures into a solid object, to a place with which you are not familiar and have no clear description, or to another plane. The circle itself is subtle and nearly impossible to notice. If you intend to keep creatures from activating it accidentally, you need to mark the circle in some way. Teleportation circle can be made permanent with a <a href=\"Permanency\">permanency</a> spell. A permanent teleportation circle that is disabled becomes inactive for 10 minutes, then can be triggered again as normal. Magic traps such as teleportation circle are hard to detect and disable. A character with the trapfinding class feature can use the Disable Device to disarm magic traps. The DC in each case is 25 + spell level, or 34 in the case of teleportation circle."
        )->setCastingTime("10 minutes")->setComponents("amber dust to cover circle worth 1,000 gp")->setRange(
                "0 ft."
            )->setTargets("")->setDuration("10 min./level (D)")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Teleport Object")->setLongDescription(
            "This spell functions like <a href=\"Teleport\">teleport</a>, except that it teleports an object, not you. Creatures and magical forces cannot be teleported. If desired, the target object can be sent to a distant location on the Ethereal Plane. In this case, the point from which the object was teleported remains faintly magical until the item is retrieved. A successful targeted <a href=\"Dispel Magic\">dispel magic</a> spell cast on that point brings the vanished item back from the Ethereal Plane."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched object of up to 50 lbs./level and 3 cu. ft./level"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Temporal Stasis")->setLongDescription(
            "You must succeed on a melee touch attack. You place the subject into a state of suspended animation. For the creature, time ceases to flow, and its condition becomes fixed. The creature does not grow older. Its body functions virtually cease, and no force or effect can harm it. This state persists until the magic is removed (such as by a successful <a href=\"Dispel Magic\">dispel magic</a> spell or a <a href=\"Freedom\">freedom</a> spell)."
        )->setCastingTime("1 standard action")->setComponents(
                "powdered diamond, emerald, ruby, and sapphire dust worth 5,000 gp"
            )->setRange("touch")->setTargets("creature touched")->setDuration("permanent")->setSavingThrow(
                "Fortitude negates"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Time Stop")->setLongDescription(
            "This spell seems to make time cease to flow for everyone but you. In fact, you speed up so greatly that all other creatures seem frozen, though they are actually still moving at their normal speeds. You are free to act for 1d4+1 rounds of apparent time. Normal and magical fire, cold, gas, and the like can still harm you. While the time stop is in effect, other creatures are invulnerable to your attacks and spells; you cannot target such creatures with any attack or spell. A spell that affects an area and has a duration longer than the remaining duration of the time stop have their normal effects on other creatures once the time stop ends. Most spellcasters use the additional time to improve their defenses, summon allies, or flee from combat. You cannot move or harm items held, carried, or worn by a creature stuck in normal time, but you can affect any item that is not in another creature's possession. You are undetectable while time stop lasts. You cannot enter an area protected by an <a href=\"Antimagic Field\">antimagic field</a> while under the effect of time stop."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1d4+1 rounds (apparent time); see text"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Tiny Hut")->setLongDescription(
            "You create an unmoving, opaque sphere of force of any color you desire around yourself. Half the sphere projects above the ground, and the lower hemisphere passes through the ground. As many as nine other Medium creatures can fit into the field with you; they can freely pass into and out of the hut without harming it. However, if you remove yourself from the hut, the spell ends. The temperature inside the hut is 70° F if the exterior temperature is between 0° and 100° F. An exterior temperature below 0° or above 100° lowers or raises the interior temperature on a 1-degree-for-1 basis. The hut also provides protection against the elements, such as rain, dust, and sandstorms. The hut withstands any wind of less than hurricane force, but a hurricane (75+ mph wind speed) or greater force destroys it. The interior of the hut is a hemisphere. You can illuminate it dimly upon command or extinguish the light as desired. Although the force field is opaque from the outside, it is transparent from within. Missiles, weapons, and most spell effects can pass through the hut without affecting it, although the occupants cannot be seen from outside the hut (they have total concealment)."
        )->setCastingTime("1 standard action")->setComponents("a small crystal bead")->setRange("20 ft.")->setTargets(
                ""
            )->setDuration("2 hours/level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Tongues")->setLongDescription(
            "This spell grants the creature touched the ability to speak and understand the language of any intelligent creature, whether it is a racial tongue or a regional dialect. The subject can speak only one language at a time, although it may be able to understand several languages. Tongues does not enable the subject to speak with creatures who don't speak. The subject can make itself understood as far as its voice carries. This spell does not predispose any creature addressed toward the subject in any way. Tongues can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("a clay model of a ziggurat")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("10 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Touch of Fatigue")->setLongDescription(
            "You channel negative energy through your touch, fatiguing the target. You must succeed on a touch attack to strike a target. The subject is immediately fatigued for the spell's duration. This spell has no effect on a creature that is already fatigued. Unlike with normal fatigue, the effect ends as soon as the spell's duration expires."
        )->setCastingTime("1 standard action")->setComponents("a drop of sweat")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 round/level")->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Touch of Idiocy")->setLongDescription(
            "With a touch, you reduce the target's mental faculties. Your successful melee touch attack applies a 1d6 penalty to the target's Intelligence, Wisdom, and Charisma scores. This penalty can't reduce any of these scores below 1. This spell's effect may make it impossible for the target to cast some or all of its spells, if the requisite ability score drops below the minimum required to cast spells of that level."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("10 min./level")->setSavingThrow("no")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Transformation")->setLongDescription(
            "You become a fighting machine--stronger, tougher, faster, and more skilled in combat. Your mindset changes so that you relish combat and you can't cast spells, even from magic items. You gain a +4 enhancement bonus to Strength, Dexterity, and Constitution, a +4 natural armor bonus to AC, a +5 competence bonus on Fortitude saves, and proficiency with all simple and martial weapons. Your base attack bonus equals your character level (which may give you multiple attacks). You lose your spellcasting ability, including your ability to use spell activation or spell completion magic items, just as if the spells were no longer on your class list."
        )->setCastingTime("1 standard action")->setComponents(
                "a potion of bull's strength, which you drink and whose effects are subsumed by the spell effects"
            )->setRange("personal")->setTargets("you")->setDuration("1 round/level")->setSavingThrow(
                ""
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Transmute Metal to Wood")->setLongDescription(
            "This spell enables you to change all metal objects within its area to wood. Weapons, armor, and other metal objects carried by creatures are affected as well. A magic object made of metal effectively has spell resistance equal to 20 + its caster level against this spell. Artifacts cannot be transmuted. Weapons converted from metal to wood take a -2 penalty on attack and damage rolls. The armor bonus of any armor converted from metal to wood is reduced by 2. Weapons changed by this spell splinter and break on any natural attack roll of 1 or 2, and armor changed by this spell loses an additional point of armor bonus every time it is struck with a natural attack roll of 19 or 20. Only <a href=\"Limited Wish\">limited wish</a>, <a href=\"Miracle\">miracle</a>, <a href=\"Wish\">wish</a>, or similar magic can restore a transmuted object to its metallic state."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Transmute Mud to Rock")->setLongDescription(
            "This spell permanently transforms normal mud or quicksand of any depth into soft stone (sandstone or a similar mineral). Any creature in the mud is allowed a Reflex save to escape before the area is hardened to stone. Transmute mud to rock counters and dispels <a href=\"Transmute Rock to Mud\">transmute rock to mud</a>."
        )->setCastingTime("1 standard action")->setComponents("sand, lime, and water")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("permanent")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Transmute Rock to Mud")->setLongDescription(
            "This spell turns natural, uncut, or unworked rock of any sort into an equal volume of mud. Magical stone is not affected by the spell. The depth of the mud created cannot exceed 10 feet. A creature unable to levitate, fly, or otherwise free itself from the mud sinks until hip- or chest-deep, reducing its speed to 5 feet and causing a -2 penalty on attack rolls and AC. Brush or similar material thrown atop the mud can support creatures able to climb on top of it. Creatures large enough to walk on the bottom can wade through the area at a speed of 5 feet. If transmute rock to mud is cast upon the ceiling of a cavern or tunnel, the mud falls to the floor and spreads out in a pool at a depth of 5 feet. The falling mud and the ensuing cave-in deal 8d6 points of bludgeoning damage to anyone caught directly beneath the targeted area, or half damage to those who succeed on Reflex saves. Castles and large stone buildings are generally immune to the effect of the spell, since transmute rock to mud can't affect worked stone and doesn't reach deep enough to undermine such buildings' foundations. However, small buildings or structures often rest upon foundations shallow enough to be damaged or even partially toppled by this spell. The mud remains until a successful <a href=\"Dispel Magic\">dispel magic</a> or <a href=\"Transmute Mud to Rock\">transmute mud to rock</a> spell restores its substance--but not necessarily its form. Evaporation turns the mud to normal dirt over a period of days. The exact time depends on exposure to the sun, wind, and normal drainage. Transmute rock to mud counters and dispels <a href=\"Transmute Mud to Rock\">transmute mud to rock</a>."
        )->setCastingTime("1 standard action")->setComponents("clay and water")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("permanent; see text")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Transport via Plants")->setLongDescription(
            "You can enter any normal plant (equal to your size or larger) and pass any distance to a plant of the same kind in a single round, regardless of the distance separating the two. The plants must be alive. The destination plant need not be familiar to you. If you are uncertain of the location of a particular kind of destination plant, you need merely designate direction and distance and the transport via plants spell moves you as close as possible to the desired location. If a particular destination plant is desired but the plant is not living, the spell fails and you are ejected from the entry plant. You can bring along objects as long as their weight doesn't exceed your maximum load. You may also bring one additional willing Medium or smaller creature (carrying gear or objects up to its maximum load) or its equivalent per three caster levels. Use the following equivalents to determine the maximum number of larger creatures you can bring along: a Large creature counts as two Medium creatures, a Huge creature counts as four Medium creatures, and so forth. All creatures to be transported by the spell must be in physical contact with one another, and at least one of those creatures must be in contact with you. You can't use this spell to travel through plant creatures. The destruction of an occupied plant slays you and any creatures you have brought along, and ejects the bodies and all carried objects from it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("unlimited")->setTargets(
                "you and touched objects or other touched willing creatures"
            )->setDuration("1 round")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Trap the Soul")->setLongDescription(
            "Trap the soul forces a creature's life force (and its material body) into a gem. The gem holds the trapped entity indefinitely or until the gem is broken and the life force is released, which allows the material body to reform. If the trapped creature is a powerful creature from another plane, it can be required to perform a service immediately upon being freed. Otherwise, the creature can go free once the gem imprisoning it is broken. Depending on the version selected, the spell can be triggered in one of two ways. Spell Completion: First, the spell can be completed by speaking its final word as a standard action as if you were casting a regular spell at the subject. This allows spell resistance (if any) and a Will save to avoid the effect. If the creature's name is spoken as well, any spell resistance is ignored and the save DC increases by 2. If the save or spell resistance is successful, the gem shatters. Trigger Object: The second method is far more insidious, for it tricks the subject into accepting a trigger object inscribed with the final spell word, automatically placing the creature's soul in the trap. To use this method, both the creature's name and the trigger word must be inscribed on the trigger object when the gem is enspelled. A <a href=\"Sympathy\">sympathy</a> spell can also be placed on the trigger object. As soon as the subject picks up or accepts the trigger object, its life force is automatically transferred to the gem without the benefit of spell resistance or a save."
        )->setCastingTime("1 standard action or see text")->setComponents(
                "gem worth 1,000 gp per HD of the trapped creature"
            )->setRange("close (25 ft. + 5 ft./2 levels)")->setTargets("one creature")->setDuration(
                "permanent; see text"
            )->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Tree Shape")->setLongDescription(
            "This spell allows you to assume the form of a Large living tree or shrub or a Large dead tree trunk with a small number of limbs. The exact type of tree, as well as its appearance, is completely under your control. Even the closest inspection cannot reveal that the tree in question is actually a magically concealed creature. To all normal tests you are, in fact, a tree or shrub, although a <a href=\"Detect Magic\">detect magic</a> spell reveals a faint transmutation on the tree. While in tree form, you can observe all that transpires around you just as if you were in your normal form, and your hit points and save bonuses remain unaffected. You gain a +10 natural armor bonus to AC but have an effective Dexterity score of 0 and a speed of 0 feet. You are immune to critical hits while in tree form. All clothing and gear carried or worn changes with you. You can dismiss tree shape as a free action (instead of as a standard action)."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Tree Stride")->setLongDescription(
            "When you cast this spell, you gain the ability to step into a tree, magically infusing yourself with the plant. Once within a tree, you can teleport from that particular tree to another tree. The trees you enter must be of the same kind, must be living, and must have girth at least equal to yours. By moving into an oak tree (for example), you instantly know the location of all other oak trees within transport range (see below) and may choose whether you want to pass into one or simply step back out of the tree you moved into. You may choose to pass to any tree of the appropriate kind within the transport range as shown on the following table. <table><tr><th>Type of Tree</th><th>Transport Range</th></tr><tr><td>Oak, ash, yew</td><td>3,000 feet</td></tr><tr class=\"alt\"><td>Elm, linden</td><td>2,000 feet</td></tr><tr><td>Other deciduous</td><td>1,500 feet</td></tr><tr class=\"alt\"><td>Any coniferous</td><td>1,000 feet</td></tr></table> You may move into a tree up to one time per caster level (passing from one tree to another counts only as moving into one tree). The spell lasts until the duration expires or you exit a tree. Each transport is a full-round action. You can, at your option, remain within a tree without transporting yourself, but you are forced out when the spell ends. If the tree in which you are concealed is chopped down or burned, you are slain if you do not exit before the process is complete."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("personal")->setTargets("you")->setDuration(
                "1 hour/level or until expended; see text"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("True Resurrection")->setLongDescription(
            "This spell functions like <a href=\"Raise Dead\">raise dead</a>, except that you can resurrect a creature that has been dead for as long as 10 years per caster level. This spell can even bring back creatures whose bodies have been destroyed, provided that you unambiguously identify the deceased in some fashion (reciting the deceased's time and place of birth or death is the most common method). Upon completion of the spell, the creature is immediately restored to full hit points, vigor, and health, with no negative levels (or Constitution points) and all of the prepared spells possessed by the creature when it died. You can revive someone killed by a death effect or someone who has been turned into an undead creature and then destroyed. This spell can also resurrect elementals or outsiders, but it can't resurrect constructs or undead creatures. Even true resurrection can't restore to life a creature who has died of old age."
        )->setCastingTime(": 10 minutes")->setComponents("diamond worth 25,000 gp")->setRange("")->setTargets(
                ""
            )->setDuration("")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("True Seeing")->setLongDescription(
            "You confer on the subject the ability to see all things as they actually are. The subject sees through normal and magical darkness, notices secret doors hidden by magic, sees the exact locations of creatures or objects under blur or displacement effects, sees invisible creatures or objects normally, sees through illusions, and sees the true form of polymorphed, changed, or transmuted things. Further, the subject can focus its vision to see into the Ethereal Plane (but not into extradimensional spaces). The range of true seeing conferred is 120 feet. True seeing, however, does not penetrate solid objects. It in no way confers X-ray vision or its equivalent. It does not negate concealment, including that caused by fog and the like. True seeing does not help the viewer see through mundane disguises, spot creatures who are simply hiding, or notice secret doors hidden by mundane means. In addition, the spell effects cannot be further enhanced with known magic, so one cannot use true seeing through a crystal ball or in conjunction with <a href=\"Clairaudience/Clairvoyance\">clairaudience/clairvoyance</a>."
        )->setCastingTime("1 standard action")->setComponents("an eye ointment that costs 250 gp")->setRange(
                "touch"
            )->setTargets("creature touched")->setDuration("1 min./level")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("True Strike")->setLongDescription(
            "You gain temporary, intuitive insight into the immediate future during your next attack. Your next single attack roll (if it is made before the end of the next round) gains a +20 insight bonus. Additionally, you are not affected by the miss chance that applies to attackers trying to strike a concealed target."
        )->setCastingTime("1 standard action")->setComponents("small wooden replica of an archery target")->setRange(
                "personal"
            )->setTargets("you")->setDuration("see text")->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Undeath to Death")->setLongDescription(
            "This spell functions like <a href=\"Circle of Death\">circle of death</a>, except that it destroys undead creatures as noted above."
        )->setCastingTime("")->setComponents("diamond powder worth 500 gp")->setRange("")->setTargets("")->setDuration(
                ""
            )->setSavingThrow("Will negates")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Undetectable Alignment")->setLongDescription(
            "An undetectable alignment spell conceals the alignment of an object or a creature from all forms of divination."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one creature or object")->setDuration("24 hours")->setSavingThrow(
                "Will negates (object)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Unhallow")->setLongDescription(
            "Unhallow makes a particular site, building, or structure an unholy site. This has three major effects. First, the site or structure is guarded by a <a href=\"Magic Circle against Good\">magic circle against good</a> effect. Second, the DC to resist negative channeled energy within the spell's area of effect gains a +4 sacred bonus and the DC to resist positive energy is reduced by 4. Spell resistance does not apply to this effect. This provision does not apply to the druid version of the spell. Finally, you may choose to fix a single spell effect to the unhallowed site. The spell effect lasts for 1 year and functions throughout the entire site, regardless of its normal duration and area or effect. You may designate whether the effect applies to all creatures, creatures that share your faith or alignment, or creatures that adhere to another faith or alignment. At the end of the year, the chosen effect lapses, but it can be renewed or replaced simply by casting unhallow again. Spell effects that may be tied to an unhallowed site include <a href=\"Aid\">aid</a>, <a href=\"Bane\">bane</a>, <a href=\"Bless\">bless</a>, <a href=\"Cause Fear\">cause fear</a>, <a href=\"Darkness\">darkness</a>, <a href=\"Daylight\">daylight</a>, <a href=\"Death Ward\">death ward</a>, <a href=\"Deeper Darkness\">deeper darkness</a>, <a href=\"Detect Magic\">detect magic</a>, <a href=\"Detect Good\">detect good</a>, <a href=\"Dimensional Anchor\">dimensional anchor</a>, <a href=\"Discern Lies\">discern lies</a>, <a href=\"Dispel Magic\">dispel magic</a>, <a href=\"Endure Elements\">endure elements</a>, <a href=\"Freedom of Movement\">freedom of movement</a>, <a href=\"Invisibility Purge\">invisibility purge</a>, <a href=\"Protection from Energy\">protection from energy</a>, <a href=\"Remove Fear\">remove fear</a>, <a href=\"Resist Energy\">resist energy</a>, <a href=\"Silence\">silence</a>, <a href=\"Tongues\">tongues</a>, and <a href=\"Zone of Truth\">zone of truth</a>. Saving throws and spell resistance might apply to these spells' effects. (See the individual spell descriptions for details.) An area can receive only one unhallow spell (and its associated spell effect) at a time. Unhallow counters but does not dispel <a href=\"Hallow\">hallow</a>."
        )->setCastingTime("24 hours")->setComponents(
                "herbs, oils, and incense worth at least 1,000 gp, plus 1,000 gp per level of the spell to be tied to the unhallowed area"
            )->setRange("touch")->setTargets("")->setDuration("instantaneous")->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Unholy Aura")->setLongDescription(
            "A malevolent darkness surrounds the subjects, protecting them from attacks, granting them resistance to spells cast by good creatures, and weakening good creatures when they strike the subjects. This abjuration has four effects. First, each warded creature gains a +4 deflection bonus to AC and a +4 resistance bonus on saves. Unlike the effect of <a href=\"Protection from Good\">protection from good</a>, this benefit applies against all attacks, not just against attacks by good creatures. Second, a warded creature gains SR 25 against good spells and spells cast by good creatures. Third, the abjuration protects the subjects from possession and mental influence, just as <a href=\"Protection from Good\">protection from good</a> does. Finally, if a good creature succeeds on a melee attack against a warded creature, the offending attacker takes 1d6 points of Strength damage (Fortitude negates)."
        )->setCastingTime("1 standard action")->setComponents("a tiny reliquary worth 500 gp")->setRange(
                "20 ft."
            )->setTargets("one creature/level in a 20-ft.-radius burst centered on you")->setDuration(
                "1 round/level (D)"
            )->setSavingThrow("see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Unholy Blight")->setLongDescription(
            "You call up unholy power to smite your enemies. The power takes the form of a cold, cloying miasma of greasy darkness. Only good and neutral (not evil) creatures are harmed by the spell. The spell deals 1d8 points of damage per two caster levels (maximum 5d8) to a good creature (or 1d6 per caster level, maximum 10d6, to a good outsider) and causes it to be sickened for 1d4 rounds. A successful Will save reduces damage to half and negates the sickened effect. The effects cannot be negated by <a href=\"Remove Disease\">remove disease</a> or <a href=\"Heal\">heal</a>, but <a href=\"Remove Curse\">remove curse</a> is effective. The spell deals only half damage to creatures who are neither evil nor good, and they are not sickened. Such a creature can reduce the damage by half again (down to one-quarter) with a successful Will save."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous (1d4 rounds); see text")->setSavingThrow(
                "Will partial"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Unseen Servant")->setLongDescription(
            "An unseen servant is an invisible, mindless, shapeless force that performs simple tasks at your command. It can run and fetch things, open unstuck doors, and hold chairs, as well as clean and mend. The servant can perform only one activity at a time, but it repeats the same activity over and over again if told to do so as long as you remain within range. It can open only normal doors, drawers, lids, and the like. It has an effective Strength score of 2 (so it can lift 20 pounds or drag 100 pounds). It can trigger traps and such, but it can exert only 20 pounds of force, which is not enough to activate certain pressure plates and other devices. It can't perform any task that requires a skill check with a DC higher than 10 or that requires a check using a skill that can't be used untrained. This servant cannot <a href=\"Fly\">fly</a>, climb, or even swim (though it can walk on water). Its base speed is 15 feet. The servant cannot attack in any way; it is never allowed an attack roll. It cannot be killed, but it dissipates if it takes 6 points of damage from area attacks. (It gets no saves against attacks.) If you attempt to send it beyond the spell's range (measured from your current position), the servant ceases to exist."
        )->setCastingTime("1 standard action")->setComponents("a piece of string and a bit of wood")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 hour/level")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Vampiric touch")->setLongDescription(
            "You must succeed on a melee touch attack. Your touch deals 1d6 points of damage per two caster levels (maximum 10d6). You gain temporary hit points equal to the damage you deal. You can't gain more than the subject's current hit points + the subject's Constitution score (which is enough to kill the subject). The temporary hit points disappear 1 hour later."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "living creature touched"
            )->setDuration("instantaneous/1 hour; see text")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Veil")->setLongDescription(
            "You instantly change the appearance of the subjects and then maintain that appearance for the spell's duration. You can make the subjects appear to be anything you wish. The subjects look, feel, and smell just like the creatures the spell makes them resemble. Affected creatures resume their normal appearances if slain. You must succeed on a Disguise check to duplicate the appearance of a specific individual. This spell gives you a +10 bonus on the check. Unwilling targets can negate the spell's effect on them by making Will saves or with spell resistance. Those who interact with the subjects can attempt Will disbelief saves to see through the glamer, but spell resistance doesn't help."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("one or more creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "concentration + 1 hour/level (D)"
            )->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Ventriloquism")->setLongDescription(
            "You can make your voice (or any sound that you can normally make vocally) seem to issue from someplace else. You can speak in any language you know. With respect to such voices and sounds, anyone who hears the sound and rolls a successful save recognizes it as illusory (but still hears it)."
        )->setCastingTime("1 standard action")->setComponents("parchment rolled into cone")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 min./level (D)")->setSavingThrow(
                "Will disbelief (if interacted with)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Virtue")->setLongDescription(
            "With a touch, you infuse a creature with a tiny surge of life, granting the subject 1 temporary hit point."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "creature touched"
            )->setDuration("1 min.")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Vision")->setLongDescription(
            "This spell functions like <a href=\"Legend Lore\">legend lore</a>, except that it works more quickly and produces some strain on you. You pose a question about some person, place, or object, then cast the spell. If the person or object is at hand or if you are in the place in question, you receive a vision about it by succeeding on a caster level check (1d20 + 1 per caster level; maximum +25) against DC 20. If only detailed information on the person, place, or object is known, the DC is 25, and the information gained is incomplete. If only rumors are known, the DC is 30, and the information gained is vague. After this spell is complete, you are fatigued."
        )->setCastingTime("1 standard action")->setComponents(
                "incense worth 250 gp & four pieces of ivory worth 50 gp each"
            )->setRange("personal")->setTargets("you")->setDuration("see text")->setSavingThrow("")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wail of the Banshee")->setLongDescription(
            "When you cast this spell, you emit a terrible, soul-chilling scream that possibly kills creatures that hear it (except for yourself). The spell affects up to one creature per caster level, inflicting 10 points of damage per caster level. Creatures closest to the point of origin are affected first."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("one living creature/level within a 40-ft.-radius spread")->setDuration(
                "instantaneous"
            )->setSavingThrow("Fortitude negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wall of Fire")->setLongDescription(
            "An immobile, blazing curtain of shimmering violet fire springs into existence. One side of the wall, selected by you, sends forth waves of heat, dealing 2d4 points of fire damage to creatures within 10 feet and 1d4 points of fire damage to those past 10 feet but within 20 feet. The wall deals this damage when it appears, and to all creatures in the area on your turn each round. In addition, the wall deals 2d6 points of fire damage + 1 point of fire damage per caster level (maximum +20) to any creature passing through it. The wall deals double damage to undead creatures. If you evoke the wall so that it appears where creatures are, each creature takes damage as if passing through the wall. If any 5-foot length of wall takes 20 points or more of cold damage in 1 round, that length goes away. (Do not divide cold damage by 2, as normal for objects.) Wall of fire can be made permanent with a <a href=\"Permanency\">permanency</a> spell. A permanent wall of fire that is extinguished by cold damage becomes inactive for 10 minutes, then reforms at normal strength."
        )->setCastingTime("1 standard action")->setComponents("a piece of phosphor")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("concentration + 1 round/level")->setSavingThrow("none")->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wall of Force")->setLongDescription(
            "A wall of force creates an invisible wall of pure force. The wall cannot move and is not easily destroyed. A wall of force is immune to <a href=\"Dispel Magic\">dispel magic</a>, although a <a href=\"Mage's Disjunction\">mage's disjunction</a> can still dispel it. A wall of force can be damaged by spells as normal, except for <a href=\"Disintegrate\">disintegrate</a>, which automatically destroys it. It can be damaged by weapons and supernatural abilities, but a wall of force has hardness 30 and a number of hit points equal to 20 per caster level. Contact with a sphere of annihilation or rod of cancellation instantly destroys a wall of force. Breath weapons and spells cannot pass through a wall of force in either direction, although <a href=\"Dimension Door\">dimension door</a>, <a href=\"Teleport\">teleport</a>, and similar effects can bypass the barrier. It blocks ethereal creatures as well as material ones (though ethereal creatures can usually circumvent the wall by going around it, through material floors and ceilings). Gaze attacks can operate through a wall of force. The caster can form the wall into a flat, vertical plane whose area is up to one 10-foot square per level. The wall must be continuous and unbroken when formed. If its surface is broken by any object or creature, the spell fails. Wall of force can be made permanent with a <a href=\"Permanency\">permanency</a> spell."
        )->setCastingTime("1 standard action")->setComponents("powdered quartz")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 round /level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wall of Ice")->setLongDescription(
            "This spell creates an anchored plane of ice or a hemisphere of ice, depending on the version selected. A wall of ice cannot form in an area occupied by physical objects or creatures. Its surface must be smooth and unbroken when created. Any creature adjacent to the wall when it is created may attempt a Reflex save to disrupt the wall as it is being formed. A successful save indicates that the spell automatically fails. Fire can melt a wall of ice, and it deals full damage to the wall (instead of the normal half damage taken by objects). Suddenly melting a wall of ice creates a great cloud of steamy fog that lasts for 10 minutes. Ice Plane: A sheet of strong, hard ice appears. The wall is 1 inch thick per caster level. It covers up to a 10-foot-square area per caster level (so a 10th-level wizard can create a wall of ice 100 feet long and 10 feet high, a wall 50 feet long and 20 feet high, or any other combination of length and height that does not exceed 1,000 square feet). The plane can be oriented in any fashion as long as it is anchored. A vertical wall need only be anchored on the floor, while a horizontal or slanting wall must be anchored on two opposite sides. Each 10-foot square of wall has 3 hit points per inch of thickness. Creatures can hit the wall automatically. A section of wall whose hit points drop to 0 is breached. If a creature tries to break through the wall with a single attack, the DC for the Strength check is 15 + caster level. Even when the ice has been broken through, a sheet of frigid air remains. Any creature stepping through it (including the one who broke through the wall) takes 1d6 points of cold damage + 1 point per caster level (no save). Hemisphere: The wall takes the form of a hemisphere whose maximum radius is 3 feet + 1 foot per caster level. The hemisphere is as hard to break through as the ice plane form, but it does not deal damage to those who go through a breach."
        )->setCastingTime("1 standard action")->setComponents("a piece of quartz or rock crystal")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Reflex negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wall of Iron")->setLongDescription(
            "You cause a flat, vertical iron wall to spring into being. The wall inserts itself into any surrounding nonliving material if its area is sufficient to do so. The wall cannot be conjured so that it occupies the same space as a creature or another object. It must always be a flat plane, though you can shape its edges to fit the available space. A wall of iron is 1 inch thick per four caster levels. You can double the wall's area by halving its thickness. Each 5-foot square of the wall has 30 hit points per inch of thickness and hardness 10. A section of wall whose hit points drop to 0 is breached. If a creature tries to break through the wall with a single attack, the DC for the Strength check is 25 + 2 per inch of thickness. If you desire, the wall can be created vertically resting on a flat surface but not attached to the surface, so that it can be tipped over to fall on and crush creatures beneath it. The wall is 50% likely to tip in either direction if left unpushed. Creatures can push the wall in one direction rather than letting it fall randomly. A creature must make a DC 40 Strength check to push the wall over. Creatures with room to flee the falling wall may do so by making successful Reflex saves. Any Large or smaller creature that fails takes 10d6 points of damage while fleeing from the wall. The wall cannot crush Huge and larger creatures. Like any iron wall, this wall is subject to rust, perforation, and other natural phenomena. Iron created by this spell is not suitable for use in the creation of other objects and cannot be sold."
        )->setCastingTime("1 standard action")->setComponents(
                "a small iron sheet plus gold dust worth 50 gp"
            )->setRange("medium (100 ft. + 10 ft./level)")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow(
                "see text"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wall of Stone")->setLongDescription(
            "This spell creates a wall of rock that merges into adjoining rock surfaces. A wall of stone is 1 inch thick per four caster levels and composed of up to one 5-foot square per level. You can double the wall's area by halving its thickness. The wall cannot be conjured so that it occupies the same space as a creature or another object. Unlike a <a href=\"Wall of Iron\">wall of iron</a>, you can create a wall of stone in almost any shape you desire. The wall created need not be vertical, nor rest upon any firm foundation; however, it must merge with and be solidly supported by existing stone. It can be used to bridge a chasm, for instance, or as a ramp. For this use, if the span is more than 20 feet, the wall must be arched and buttressed. This requirement reduces the spell's area by half. The wall can be crudely shaped to allow crenellations, battlements, and so forth by likewise reducing the area. Like any other stone wall, this one can be destroyed by a <a href=\"Disintegrate\">disintegrate</a> spell or by normal means such as breaking and chipping. Each 5-foot square of the wall has hardness 8 and 15 hit points per inch of thickness. A section of wall whose hit points drop to 0 is breached. If a creature tries to break through the wall with a single attack, the DC for the Strength check is 20 + 2 per inch of thickness. It is possible, but difficult, to trap mobile opponents within or under a wall of stone, provided the wall is shaped so it can hold the creatures. Creatures can avoid entrapment with successful Reflex saves."
        )->setCastingTime("1 standard action")->setComponents("a small block of granite")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("instantaneous")->setSavingThrow("see text")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wall of Thorns")->setLongDescription(
            "A wall of thorns spell creates a barrier of very tough, pliable, tangled brush bearing needle-sharp thorns as long as a human's finger. Any creature forced into or attempting to move through a wall of thorns takes piercing damage per round of movement equal to 25 minus the creature's AC. Dexterity and dodge bonuses to AC do not count for this calculation. (Creatures with an AC of 25 or higher, without considering Dexterity and dodge bonuses, take no damage from contact with the wall.) You can make the wall as thin as 5 feet thick, which allows you to shape the wall as a number of 10-by-10-by-5-foot blocks equal to twice your caster level. This has no effect on the damage dealt by the thorns, but any creature attempting to break through takes that much less time to force its way through the barrier. Creatures can force their way slowly through the wall by making a Strength check as a full-round action. For every 5 points by which the check exceeds 20, a creature moves 5 feet (up to a maximum distance equal to its normal land speed). Of course, moving or attempting to move through the thorns incurs damage as described above. A creature trapped in the thorns can choose to remain motionless in order to avoid taking any more damage. Any creature within the area of the spell when it is cast takes damage as if it had moved into the wall and is caught inside. In order to escape, it must attempt to push its way free, or it can wait until the spell ends. Creatures with the ability to pass through overgrown areas unhindered can pass through a wall of thorns at normal speed without taking damage. A wall of thorns can be breached by slow work with edged weapons. Chopping away at the wall creates a safe passage 1 foot deep for every 10 minutes of work. Normal fire cannot harm the barrier, but magical fire burns it away in 10 minutes."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("10 min./level (D)")->setSavingThrow("none")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Warp Wood")->setLongDescription(
            "You cause wood to bend and warp, permanently destroying its straightness, form, and strength. A warped door springs open (or becomes stuck, requiring a Strength check to open, at your option). A boat or ship springs a leak. Warped ranged weapons are useless. A warped melee weapon causes a -4 penalty on attack rolls. You may warp one Small or smaller object or its equivalent per caster level. A Medium object counts as two Small objects, a Large object as four, a Huge object as eight, a Gargantuan object as 16, and a Colossal object as 32. Alternatively, you can unwarp wood (effectively warping it back to normal) with this spell. Make whole, on the other hand, does no good in repairing a warped item. You can combine multiple consecutive warp wood spells to warp (or unwarp) an object that is too large for you to warp with a single spell. Until the object is completely warped, it suffers no ill effects."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("1 Small wooden object/level, all within a 20-ft. radius")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Water Breathing")->setLongDescription(
            "The transmuted creatures can breathe water freely. Divide the duration evenly among all the creatures you touch. The spell does not make creatures unable to breathe air."
        )->setCastingTime("1 standard action")->setComponents("short reed or piece of straw")->setRange(
                "touch"
            )->setTargets("living creatures touched")->setDuration("2 hours/level; see text")->setSavingThrow(
                "Will negates (harmless)"
            )->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Water Walk")->setLongDescription(
            "The transmuted creatures can tread on any liquid as if it were firm ground. Mud, oil, snow, quicksand, running water, ice, and even lava can be traversed easily, since the subjects' feet hover an inch or two above the surface. Creatures crossing molten lava still take damage from the heat because they are near it. The subjects can walk, run, charge, or otherwise move across the surface as if it were normal ground. If the spell is cast underwater (or while the subjects are partially or wholly submerged in whatever liquid they are in), the subjects are borne toward the surface at 60 feet per round until they can stand on it."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched creature/level"
            )->setDuration("10 min./level (D)")->setSavingThrow("Will negates (harmless)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Waves of Exhaustion")->setLongDescription(
            "Waves of negative energy cause all living creatures in the spell's area to become exhausted. This spell has no effect on a creature that is already exhausted."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("60 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("no")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Waves of Fatigue")->setLongDescription(
            "Waves of negative energy render all living creatures in the spell's area fatigued. This spell has no effect on a creature that is already fatigued."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("30 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("no")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Web")->setLongDescription(
            "Web creates a many-layered mass of strong, sticky strands. These strands trap those caught in them. The strands are similar to spiderwebs but far larger and tougher. These masses must be anchored to two or more solid and diametrically opposed points or else the web collapses upon itself and disappears. Creatures caught within a web become grappled by the sticky fibers. Attacking a creature in a web doesn't cause you to become grappled. Anyone in the effect's area when the spell is cast must make a Reflex save. If this save succeeds, the creature is inside the web but is otherwise unaffected. If the save fails, the creature gains the grappled condition, but can break free by making a combat maneuver check or Escape Artist check as a standard action against the DC of this spell. The entire area of the web is considered difficult terrain. Anyone moving through the webs must make a combat maneuver check or Escape Artist check as part of their move action, with a DC equal to the spell's DC. Creatures that fail lose their movement and become grappled in the first square of webbing that they enter. If you have at least 5 feet of web between you and an opponent, it provides cover. If you have at least 20 feet of web between you, it provides total cover. The strands of a web spell are flammable. A flaming weapon can slash them away as easily as a hand brushes away cobwebs. Any fire can set the webs alight and burn away one 5-foot square in 1 round. All creatures within flaming webs take 2d4 points of fire damage from the flames. Web can be made permanent with a <a href=\"Permanency\">permanency</a> spell. A permanent web that is damaged (but not destroyed) regrows in 10 minutes."
        )->setCastingTime("1 standard action")->setComponents("spider web")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("10 min./level (D)")->setSavingThrow("Reflex negates")->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Weird")->setLongDescription(
            "This spell functions like <a href=\"Phantasmal Killer\">phantasmal killer</a>, except it can affect more than one creature. Only the affected creatures see the phantasmal creatures attacking them, though you see the attackers as shadowy shapes. If a subject's Fortitude save succeeds, it still takes 3d6 points of damage and is stunned for 1 round. The subject also takes 1d4 points of Strength damage."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("any number of creatures, no two of which can be more than 30 ft. apart")->setDuration(
                "instantaneous"
            )->setSavingThrow("Will disbelief, then Fortitude partial")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Whirlwind")->setLongDescription(
            "This spell creates a powerful cyclone of raging wind that moves through the air, along the ground, or over water at a speed of 60 feet per round. You can concentrate on controlling the cyclone's every movement or specify a simple program. Directing the cyclone's movement or changing its programmed movement is a standard action for you. The cyclone always moves during your turn. If the cyclone exceeds the spell's range, it moves in a random, uncontrolled fashion for 1d3 rounds and then dissipates. (You can't regain control of the cyclone, even if it comes back within range.) Any Large or smaller creature that comes in contact with the spell effect must succeed on a Reflex save or take 3d6 points of damage. A Medium or smaller creature that fails its first save must succeed on a second one or be picked up bodily by the cyclone and held suspended in its powerful winds, taking 1d8 points of damage each round on your turn with no save allowed. You may direct the cyclone to eject any carried creatures whenever you wish, depositing the hapless souls wherever the cyclone happens to be when they are released."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "long (400 ft. + 40 ft./level)"
            )->setTargets("")->setDuration("1 round/level (D)")->setSavingThrow("Reflex negates")->setSpellResistance(
                1
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Whispering Wind")->setLongDescription(
            "You send a message or sound on the wind to a designated spot. The whispering wind travels to a specific location within range that is familiar to you, provided that it can find a way to the location. A whispering wind is as gentle and unnoticed as a zephyr until it reaches the location. It then delivers its whisper-quiet message or other sound. Note that the message is delivered regardless of whether anyone is present to hear it. The wind then dissipates. You can prepare the spell to bear a message of no more than 25 words, cause the spell to deliver other sounds for 1 round, or merely have the whispering wind seem to be a faint stirring of the air. You can likewise cause the whispering wind to move as slowly as 1 mile per hour or as quickly as 1 mile per 10 minutes. When the spell reaches its objective, it swirls and remains in place until the message is delivered. As with <a href=\"Magic Mouth\">magic mouth</a>, whispering wind cannot speak verbal components, use command words, or activate magical effects."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("1 mile/level")->setTargets(
                ""
            )->setDuration("no more than 1 hour/level or until discharged (destination is reached)")->setSavingThrow(
                "none"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wind Walk")->setLongDescription(
            "You alter the substance of your body to a cloudlike vapor (as the <a href=\"Gaseous Form\">gaseous form</a> spell) and move through the air, possibly at great speed. You can take other creatures with you, each of which acts independently. Normally, a wind walker flies at a speed of 10 feet with perfect maneuverability. If desired by the subject, a magical wind wafts a wind walker along at up to 600 feet per round (60 mph) with poor maneuverability. Wind walkers are not invisible but rather appear misty and translucent. If fully clothed in white, they are 80% likely to be mistaken for clouds, fog, vapors, or the like. A wind walker can regain its physical form as desired and later resume the cloud form. Each change to and from vaporous form takes 5 rounds, which counts toward the duration of the spell (as does any time spent in physical form). As noted above, you can dismiss the spell, and you can even dismiss it for individual wind walkers and not others. For the last minute of the spell's duration, a wind walker in cloud form automatically descends 60 feet per round (for a total of 600 feet), though it may descend faster if it wishes. This descent serves as a warning that the spell is about to end."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "you and one touched creature per three levels"
            )->setDuration("1 hour/level (D); see text")->setSavingThrow(
                "no and Will negates (harmless)"
            )->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wind Wall")->setLongDescription(
            "An invisible vertical curtain of wind appears. It is 2 feet thick and of considerable strength. It is a roaring blast sufficient to blow away any bird smaller than an eagle, or tear papers and similar materials from unsuspecting hands. (A Reflex save allows a creature to maintain its grasp on an object.) Tiny and Small flying creatures cannot pass through the barrier. Loose materials and cloth garments fly upward when caught in a wind wall. Arrows and bolts are deflected upward and miss, while any other normal ranged weapon passing through the wall has a 30% miss chance. (A giant-thrown boulder, a siege engine projectile, and other massive ranged weapons are not affected.) Gases, most gaseous breath weapons, and creatures in gaseous form cannot pass through the wall (although it is no barrier to incorporeal creatures). While the wall must be vertical, you can shape it in any continuous path along the ground that you like. It is possible to create cylindrical or square wind walls to enclose specific points. "
        )->setCastingTime("1 standard action")->setComponents("a tiny fan and an exotic feather")->setRange(
                "medium (100 ft. + 10 ft./level)"
            )->setTargets("")->setDuration("1 round/level")->setSavingThrow("none")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wish")->setLongDescription(
            "Wish is the mightiest spell a wizard or sorcerer can cast. By simply speaking aloud, you can alter reality to better suit you. Even wish, however, has its limits. A wish can produce any one of the following effects. * Duplicate any sorcerer/wizard spell of 8th level or lower, provided the spell does not belong to one of your opposition schools.* Duplicate any non-sorcerer/wizard spell of 7th level or lower, provided the spell does not belong to one of your opposition schools.* Duplicate any sorcerer/wizard spell of 7th level or lower, even if it belongs to one of your opposition schools.* Duplicate any non-sorcerer/wizard spell of 6th level or lower, even if it belongs to one of your opposition schools. * Undo the harmful effects of many other spells, such as <a href=\"Geas/Quest\">geas/quest</a> or <a href=\"Insanity\">insanity</a>.* Grant a creature a +1 inherent bonus to an ability score. Two to five wish spells cast in immediate succession can grant a creature a +2 to +5 inherent bonus to an ability score (two wishes for a +2 inherent bonus, three wishes for a +3 inherent bonus, and so on). Inherent bonuses are instantaneous, so they cannot be dispelled. Note: An inherent bonus may not exceed +5 for a single ability score, and inherent bonuses to a particular ability score do not stack, so only the best one applies.* Remove injuries and afflictions. A single wish can aid one creature per caster level, and all subjects are cured of the same kind of affliction. For example, you could heal all the damage you and your companions have taken, or remove all poison effects from everyone in the party, but not do both with the same wish. * Revive the dead. A wish can bring a dead creature back to life by duplicating a <a href=\"Resurrection\">resurrection</a> spell. A wish can revive a dead creature whose body has been destroyed, but the task takes two wishes: one to recreate the body and another to infuse the body with life again. A wish cannot prevent a character who was brought back to life from gaining a permanent negative level.* Transport travelers. A wish can lift one creature per caster level from anywhere on any plane and place those creatures anywhere else on any plane regardless of local conditions. An unwilling target gets a Will save to negate the effect, and spell resistance (if any) applies.* Undo misfortune. A wish can undo a single recent event. The wish forces a reroll of any roll made within the last round (including your last turn). Reality reshapes itself to accommodate the new result. For example, a wish could undo an opponent's successful save, a foe's successful critical hit (either the attack roll or the critical roll), a friend's failed save, and so on. The reroll, however, may be as bad as or worse than the original roll. An unwilling target gets a Will save to negate the effect, and spell resistance (if any) applies.You may try to use a wish to produce greater effects than these, but doing so is dangerous. (The wish may pervert your intent into a literal but undesirable fulfillment or only a partial fulfillment, at the GM's discretion.) Duplicated spells allow saves and spell resistance as normal (but save DCs are for 9th-level spells). When a wish duplicates a spell with a material component that costs more than 10,000 gp, you must provide that component (in addition to the 25,000 gp diamond component for this spell)."
        )->setCastingTime("1 standard action")->setComponents("diamond worth 25,000 gp")->setRange(
                "see text"
            )->setTargets("see text")->setDuration("see text")->setSavingThrow("none, see text")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Wood Shape")->setLongDescription(
            "Wood shape enables you to form one existing piece of wood into any shape that suits your purpose. While it is possible to make crude coffers, doors, and so forth, fine detail isn't possible. There is a 30% chance that any shape that includes moving parts simply doesn't work."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("touch")->setTargets(
                "one touched piece of wood no larger than 10 cu. ft. + 1 cu. ft./level"
            )->setDuration("instantaneous")->setSavingThrow("Will negates (object)")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Word of Chaos")->setLongDescription(
            "Any nonchaotic creature within the area of a word of chaos spell suffers the following ill effects, depending on their HD. <table><tr><th>HD</th><th>Effect</th></tr><tr><td>Equal to caster level</td><td>Deafened</td></tr><tr class=\"alt\"><td>Up to caster level -1</td><td>Stunned, deafened</td></tr><tr><td>Up to caster level -5</td><td>Confused, stunned, deafened</td></tr><tr class=\"alt\"><td>Up to caster level -10</td><td>Killed, confused, stunned, deafened</td></tr></table> The effects are cumulative and concurrent. A successful Will save reduces or eliminates these effects. Creatures affected by multiple effects make only one save and apply the result to all the effects. Deafened: The creature is deafened for 1d4 rounds. Save negates. Stunned: The creature is stunned for 1 round. Save negates. Confused: The creature is confused for 1d10 minutes. This is a mind-affecting enchantment effect. Save reduces the confused effect to 1 round. Killed: Living creatures die. Undead creatures are destroyed. Save negates. If the save is successful, the creature instead takes 3d6 points of damage + 1 point per caster level (maximum +25). Furthermore, if you are on your home plane when you cast this spell, nonchaotic extraplanar creatures within the area are instantly banished back to their home planes. Creatures so banished cannot return for at least 24 hours. This effect takes place regardless of whether the creatures hear the word of chaos or not. The banishment effect allows a Will save (at a -4 penalty) to negate. Creatures whose HD exceed your caster level are unaffected by word of chaos."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("40 ft.")->setTargets("")->setDuration(
                "instantaneous"
            )->setSavingThrow("none or Will negates")->setSpellResistance(true);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Word of Recall")->setLongDescription(
            "Word of recall teleports you instantly back to your sanctuary when the word is uttered. You must designate the sanctuary when you prepare the spell, and it must be a very familiar place. The actual point of arrival is a designated area no larger than 10 feet by 10 feet. You can be transported any distance within a plane but cannot travel between planes. You can transport, in addition to yourself, any objects you carry, as long as their weight doesn't exceed your maximum load. You may also bring one additional willing Medium or smaller creature (carrying gear or objects up to its maximum load) or its equivalent per three caster levels. A Large creature counts as two Medium creatures, a Huge creature counts as two Large creatures, and so forth. All creatures to be transported must be in contact with one another, and at least one of those creatures must be in contact with you. Exceeding this limit causes the spell to fail. An unwilling creature can't be teleported by word of recall. Likewise, a creature's Will save (or spell resistance) prevents items in its possession from being teleported. Unattended, nonmagical objects receive no saving throw."
        )->setCastingTime("1 standard action")->setComponents("")->setRange("unlimited")->setTargets(
                "you and touched objects or other willing creatures"
            )->setDuration("instantaneous")->setSavingThrow(
                "none or Will negates (harmless, object)"
            )->setSpellResistance(
                0
            );
        $manager->persist($spell);

        $spell = (new Spell())->setName("Zone of Silence")->setLongDescription(
            "By casting zone of silence, you manipulate sound waves in your immediate vicinity so that you and those within the spell's area can converse normally, yet no one outside can hear your voices or any other noises from within, including language-dependent or sonic spell effects. This effect is centered on you and moves with you. Anyone who enters the zone immediately becomes subject to its effects, but those who leave are no longer affected. Note, however, that a successful DC 20 Linguistics check to read lips can still reveal what's said inside a zone of silence."
        )->setCastingTime("1 round")->setComponents("")->setRange("personal")->setTargets("")->setDuration(
                "1 hour/level (D)"
            )->setSavingThrow("")->setSpellResistance(false);
        $manager->persist($spell);

        $spell = (new Spell())->setName("Zone of Truth")->setLongDescription(
            "Creatures within the emanation area (or those who enter it) can't speak any deliberate and intentional lies. Each potentially affected creature is allowed a save to avoid the effects when the spell is cast or when the creature first enters the emanation area. Affected creatures are aware of this enchantment. Therefore, they may avoid answering questions to which they would normally respond with a lie, or they may be evasive as long as they remain within the boundaries of the truth. Creatures who leave the area are free to speak as they choose."
        )->setCastingTime("1 standard action")->setComponents("")->setRange(
                "close (25 ft. + 5 ft./2 levels)"
            )->setTargets("")->setDuration("1 min./level")->setSavingThrow("Will negates")->setSpellResistance(true);
        $manager->persist($spell);


        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}