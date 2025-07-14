<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de données Blog - Méthode Merise</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        
        h2 {
            color: #34495e;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 1.8em;
            border-left: 5px solid #3498db;
            padding-left: 15px;
        }
        
        h3 {
            color: #2c3e50;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .section {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        
        .merise-level {
            background-color: #ecf0f1;
            padding: 25px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 6px solid #e74c3c;
        }
        
        .mcd-diagram {
            background-color: white;
            padding: 30px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            border: 2px solid #bdc3c7;
        }
        
        .entity {
            display: inline-block;
            border: 2px solid #2c3e50;
            background-color: #3498db;
            color: white;
            padding: 15px 25px;
            margin: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            min-width: 120px;
        }
        
        .association {
            display: inline-block;
            border: 2px solid #e74c3c;
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 25px;
            font-weight: bold;
            text-align: center;
        }
        
        .cardinality {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.2em;
            margin: 0 10px;
        }
        
        .attributes-list {
            background-color: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #bdc3c7;
        }
        
        .primary-key {
            color: #e74c3c;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .foreign-key {
            color: #f39c12;
            font-weight: bold;
            font-style: italic;
        }
        
        .table-structure {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }
        
        .sql-code {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
            margin: 15px 0;
            border-left: 4px solid #e74c3c;
        }
        
        .diagram-container {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            border: 2px solid #bdc3c7;
        }
        
        .relationship-line {
            border-top: 2px solid #34495e;
            width: 100px;
            margin: 20px auto;
            position: relative;
        }
        
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #3498db;
            color: #0c5460;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-color: #f39c12;
            color: #856404;
        }
        
        .definition {
            background-color: #e8f5e8;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #27ae60;
            font-style: italic;
        }
        
        .example {
            background-color: #fef9e7;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #f1c40f;
        }
        
        .navigation {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #34495e;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
        }
        
        .navigation a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 5px 0;
            padding: 5px 10px;
            border-radius: 3px;
            transition: background-color 0.3s;
        }
        
        .navigation a:hover {
            background-color: #3498db;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        
        .constraint {
            color: #e74c3c;
            font-weight: bold;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <a href="#mcd">MCD</a>
        <a href="#mld">MLD</a>
        <a href="#mpd">MPD</a>
        <a href="#dictionnaire">Dictionnaire</a>
    </div>

    <div class="container">
        <h1>Base de données Blog - Méthode Merise</h1>
        
        <div class="alert alert-info">
            <strong>Objectif :</strong> Concevoir une base de données pour un système de blog permettant à des utilisateurs de créer et publier des articles. La méthode Merise nous permettra de passer du niveau conceptuel au niveau physique de manière méthodique.
        </div>

        <div class="section">
            <h2>Introduction à la méthode Merise</h2>
            <p>La méthode Merise est une méthode d'analyse et de conception des systèmes d'information. Elle utilise trois niveaux d'abstraction :</p>
            
            <div class="definition">
                <strong>Niveau conceptuel (MCD) :</strong> Représente le système d'information indépendamment de son aspect informatique. Il doit être compréhensible par tous : informaticiens, employés, personnel de direction, etc.
            </div>
            
            <div class="definition">
                <strong>Niveau logique (MLD) :</strong> Les entités et associations du MCD sont transformées en tables relationnelles, en tenant compte des contraintes du modèle relationnel.
            </div>
            
            <div class="definition">
                <strong>Niveau physique (MPD) :</strong> Le MLD est adapté au SGBD choisi avec les types de données spécifiques, les index, les contraintes de performance, etc.
            </div>
        </div>

        <section id="mcd" class="merise-level">
            <h2>Niveau conceptuel (MCD)</h2>
            
            <h3>Analyse du domaine</h3>
            <p>Notre système de blog doit gérer :</p>
            <ul>
                <li>Des <strong>utilisateurs</strong> qui s'inscrivent sur la plateforme</li>
                <li>Des <strong>articles</strong> rédigés par ces utilisateurs</li>
                <li>La relation "un utilisateur écrit des articles"</li>
            </ul>

            <h3>Identification des entités</h3>
            
            <div class="example">
                <strong>Entité :</strong> Elle regroupe l'information statique et durable. Une entité est représentée par un nom commun écrit en majuscules et au singulier.
            </div>

            <div class="attributes-list">
                <h4>UTILISATEUR</h4>
                <ul>
                    <li><span class="primary-key">id_utilisateur</span> : identifiant unique</li>
                    <li>nom_uti : nom de famille</li>
                    <li>prenom_uti : prénom</li>
                    <li>email_uti : adresse email unique</li>
                    <li>motdepasse_uti : mot de passe chiffré</li>
                    <li>dateinscription_uti : date d'inscription</li>
                    <li>actif_uti : statut du compte (actif/inactif)</li>
                </ul>
            </div>

            <div class="attributes-list">
                <h4>ARTICLE</h4>
                <ul>
                    <li><span class="primary-key">id_article</span> : identifiant unique</li>
                    <li>titre_art : titre de l'article</li>
                    <li>contenu_art : contenu de l'article</li>
                    <li>datecreation_art : date et heure de création</li>
                    <li>datemodification_art : date et heure de modification</li>
                    <li>publie_art : statut de publication</li>
                    <li>nombrevues_art : nombre de vues</li>
                </ul>
            </div>

            <h3>Association</h3>
            
            <div class="example">
                <strong>Association :</strong> Elle matérialise la dynamique du système et donc les relations entre les entités. L'association est représentée par un verbe d'action ou d'état à l'infinitif.
            </div>

            <div class="diagram-container">
                <div class="entity">UTILISATEUR</div>
                <span class="cardinality">1,1</span>
                <div class="association">ÉCRIRE</div>
                <span class="cardinality">0,n</span>
                <div class="entity">ARTICLE</div>
            </div>

            <h3>Cardinalités</h3>
            <div class="alert alert-warning">
                <strong>Lecture des cardinalités :</strong>
                <ul>
                    <li><strong>UTILISATEUR (1,1) :</strong> Un article est écrit par un et un seul utilisateur</li>
                    <li><strong>ARTICLE (0,n) :</strong> Un utilisateur peut écrire zéro, un ou plusieurs articles</li>
                </ul>
            </div>

            <div class="definition">
                <strong>Cardinalité :</strong> La cardinalité d'une patte reliant une association et une entité précise le nombre de fois minimal et maximal d'interventions d'une occurrence de l'entité avec l'association.
                <br><br>
                Les cardinalités admises sont :
                <ul>
                    <li><strong>1-1 :</strong> une occurrence participe minimum et maximum 1 fois</li>
                    <li><strong>0-1 :</strong> une occurrence peut ne pas participer ou participer 1 fois maximum</li>
                    <li><strong>1-n :</strong> une occurrence participe au moins 1 fois, sans limitation</li>
                    <li><strong>0-n :</strong> une occurrence peut ne pas participer ou participer sans limitation</li>
                </ul>
            </div>

            <h3>Types de relations et leurs transformations</h3>
            
            <div class="example">
                <strong>🔑 Phrase magique pour choisir les cardinalités :</strong>
                <br><br>
                <em>"Pour déterminer la cardinalité, je me pose la question dans les DEUX sens :"</em>
                <ul>
                    <li><strong>Sens 1 :</strong> "Combien d'ARTICLES peut écrire UN utilisateur ?" → 0 à plusieurs (0,n)</li>
                    <li><strong>Sens 2 :</strong> "Combien d'UTILISATEURS peuvent écrire UN article ?" → 1 seul (1,1)</li>
                </ul>
                <br>
                <strong>💡 Astuce :</strong> Toujours commencer par le minimum (0 ou 1), puis le maximum (1 ou n).
            </div>

            <h4>🔹 Relation One-to-Many (1:N) - Un vers plusieurs</h4>
            <div class="diagram-container">
                <div class="entity">UTILISATEUR</div>
                <span class="cardinality">1,1</span>
                <div class="association">ÉCRIRE</div>
                <span class="cardinality">0,n</span>
                <div class="entity">ARTICLE</div>
                <br><br>
                <strong>Exemple actuel :</strong> Un utilisateur écrit plusieurs articles, un article est écrit par un seul utilisateur
            </div>
            
            <div class="alert alert-info">
                <strong>Transformation One-to-Many :</strong> L'association disparaît. La clé primaire de l'entité côté (1,1) migre comme clé étrangère dans l'entité côté (0,n).
                <br><strong>Résultat :</strong> ARTICLE reçoit la clé étrangère #id_utilisateur
            </div>

            <h4>🔹 Relation Many-to-Many (N:N) - Plusieurs vers plusieurs</h4>
            <div class="diagram-container">
                <div class="entity">ARTICLE</div>
                <span class="cardinality">0,n</span>
                <div class="association">APPARTENIR</div>
                <span class="cardinality">1,n</span>
                <div class="entity">CATÉGORIE</div>
                <br><br>
                <strong>Exemple :</strong> Un article peut appartenir à plusieurs catégories, une catégorie contient plusieurs articles
            </div>
            
            <div class="alert alert-warning">
                <strong>Transformation Many-to-Many :</strong> L'association devient une table de liaison ayant comme clé primaire la concaténation des clés primaires des deux entités.
                <br><strong>Résultat :</strong> Table APPARTENIR(#id_article, #id_categorie)
            </div>

            <h4>🔹 Relation One-to-One (1:1) - Un vers un</h4>
            <div class="diagram-container">
                <div class="entity">UTILISATEUR</div>
                <span class="cardinality">1,1</span>
                <div class="association">AVOIR</div>
                <span class="cardinality">0,1</span>
                <div class="entity">PROFIL</div>
                <br><br>
                <strong>Exemple :</strong> Un utilisateur a un profil, un profil appartient à un utilisateur
            </div>
            
            <div class="alert alert-info">
                <strong>Transformation One-to-One :</strong> L'association disparaît. La clé primaire de l'entité côté (1,1) migre comme clé étrangère dans l'entité côté (0,1).
                <br><strong>Résultat :</strong> PROFIL reçoit la clé étrangère #id_utilisateur
            </div>

            <h3>Guide pratique pour déterminer les cardinalités</h3>
            
            <div class="example">
                <strong>📋 Méthodologie en 3 étapes :</strong>
                <ol>
                    <li>
                        <strong>Identifier la relation :</strong> Quel verbe décrit l'action entre les entités ?
                        <br><em>Ex: UTILISATEUR → ÉCRIRE → ARTICLE</em>
                    </li>
                    <li>
                        <strong>Poser les bonnes questions :</strong>
                        <ul>
                            <li>"Combien d'articles <u>minimum</u> et <u>maximum</u> peut écrire un utilisateur ?"</li>
                            <li>"Combien d'utilisateurs <u>minimum</u> et <u>maximum</u> peuvent écrire un article ?"</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Appliquer la logique métier :</strong>
                        <ul>
                            <li>Un nouvel utilisateur n'a pas encore d'articles → <strong>minimum 0</strong></li>
                            <li>Un utilisateur peut écrire beaucoup d'articles → <strong>maximum n</strong></li>
                            <li>Un article doit avoir un auteur → <strong>minimum 1</strong></li>
                            <li>Un article n'a qu'un seul auteur → <strong>maximum 1</strong></li>
                        </ul>
                    </li>
                </ol>
            </div>

            <h4>Exemples concrets d'autres relations</h4>
            
            <div class="attributes-list">
                <h4>Relation MANY-TO-MANY : ARTICLE ↔ TAG</h4>
                <div class="diagram-container">
                    <div class="entity">ARTICLE</div>
                    <span class="cardinality">0,n</span>
                    <div class="association">ÉTIQUETER</div>
                    <span class="cardinality">0,n</span>
                    <div class="entity">TAG</div>
                </div>
                <p><strong>Questions :</strong></p>
                <ul>
                    <li>"Un article peut avoir combien de tags ?" → 0 à plusieurs (0,n)</li>
                    <li>"Un tag peut étiqueter combien d'articles ?" → 0 à plusieurs (0,n)</li>
                </ul>
                <p><strong>Transformation :</strong> Table ÉTIQUETER(#id_article, #id_tag)</p>
            </div>

            <div class="attributes-list">
                <h4>Relation ONE-TO-MANY : UTILISATEUR ↔ COMMENTAIRE</h4>
                <div class="diagram-container">
                    <div class="entity">UTILISATEUR</div>
                    <span class="cardinality">1,1</span>
                    <div class="association">RÉDIGER</div>
                    <span class="cardinality">0,n</span>
                    <div class="entity">COMMENTAIRE</div>
                </div>
                <p><strong>Questions :</strong></p>
                <ul>
                    <li>"Un utilisateur peut rédiger combien de commentaires ?" → 0 à plusieurs (0,n)</li>
                    <li>"Un commentaire est rédigé par combien d'utilisateurs ?" → 1 seul (1,1)</li>
                </ul>
                <p><strong>Transformation :</strong> COMMENTAIRE reçoit #id_utilisateur</p>
            </div>

            <div class="attributes-list">
                <h4>Relation ONE-TO-ONE : UTILISATEUR ↔ AVATAR</h4>
                <div class="diagram-container">
                    <div class="entity">UTILISATEUR</div>
                    <span class="cardinality">0,1</span>
                    <div class="association">POSSÉDER</div>
                    <span class="cardinality">1,1</span>
                    <div class="entity">AVATAR</div>
                </div>
                <p><strong>Questions :</strong></p>
                <ul>
                    <li>"Un utilisateur peut avoir combien d'avatars ?" → 0 ou 1 (0,1)</li>
                    <li>"Un avatar appartient à combien d'utilisateurs ?" → 1 seul (1,1)</li>
                </ul>
                <p><strong>Transformation :</strong> UTILISATEUR reçoit #id_avatar</p>
            </div>
        </section>

        <section id="mld" class="merise-level">
            <h2>Niveau logique (MLD)</h2>
            
            <div class="definition">
                <strong>Règle de transformation :</strong> Les entités mises en relation deviennent des tables. Pour une association (1,1)-(0,n), l'association disparaît et la clé de l'entité côté (1,1) migre vers l'entité côté (0,n) comme clé étrangère.
            </div>

            <h3>Transformation du MCD en MLD</h3>
            
            <div class="table-structure">
UTILISATEUR: id_utilisateur, nom_uti, prenom_uti, email_uti, motdepasse_uti, dateinscription_uti, actif_uti

ARTICLE: id_article, titre_art, contenu_art, datecreation_art, datemodification_art, publie_art, nombrevues_art, #id_utilisateur
            </div>

            <div class="alert alert-info">
                <strong>Explication :</strong> L'association ÉCRIRE disparaît car elle est de type (1,1)-(0,n). La clé primaire de UTILISATEUR (id_utilisateur) devient une clé étrangère dans la table ARTICLE, matérialisant ainsi la relation "un article est écrit par un utilisateur".
            </div>

            <h3>Règles de transformation MCD → MLD</h3>
            
            <div class="example">
                <strong>📚 Règles universelles de transformation :</strong>
                <br><br>
                
                <strong>🔸 Relation (1,1) - (0,n) ou (1,n) :</strong>
                <br>→ L'association disparaît
                <br>→ La clé de l'entité côté (1,1) migre vers l'entité côté (0,n) ou (1,n)
                <br><em>Exemple : UTILISATEUR (1,1) ↔ ÉCRIRE ↔ (0,n) ARTICLE</em>
                <br><strong>Résultat :</strong> ARTICLE reçoit #id_utilisateur
                <br><br>
                
                <strong>🔸 Relation (0,n) - (0,n) ou (1,n) - (1,n) :</strong>
                <br>→ L'association devient une table de liaison
                <br>→ Clé primaire = concaténation des clés des entités liées
                <br><em>Exemple : ARTICLE (0,n) ↔ ÉTIQUETER ↔ (0,n) TAG</em>
                <br><strong>Résultat :</strong> Table ÉTIQUETER(#id_article, #id_tag)
                <br><br>
                
                <strong>🔸 Relation (0,1) - (1,1) :</strong>
                <br>→ L'association disparaît
                <br>→ La clé de l'entité côté (1,1) migre vers l'entité côté (0,1)
                <br><em>Exemple : UTILISATEUR (0,1) ↔ POSSÉDER ↔ (1,1) AVATAR</em>
                <br><strong>Résultat :</strong> UTILISATEUR reçoit #id_avatar
                <br><br>
                
                <strong>🔸 Relation (1,1) - (1,1) :</strong>
                <br>→ Fusion des deux entités en une seule table
                <br>→ Ou migration de clé selon la logique métier
                <br><em>Exemple : rare en pratique</em>
            </div>

            <div class="alert alert-warning">
                <strong>💡 Règle d'or :</strong> Les clés étrangères vont toujours du côté des cardinalités les plus élevées (n) ou optionnelles (0). On évite ainsi les valeurs nulles dans les clés étrangères quand c'est possible.
            </div>

            <h3>Règles de nommage Merise</h3>
            <div class="example">
                Pour éviter les synonymes et polysèmes, on fait suivre le nom de l'attribut par un suffixe de 4 caractères : l'underscore et les 3 premières lettres de l'entité.
                <br><br>
                Exemples :
                <ul>
                    <li>nom_uti (nom de l'utilisateur)</li>
                    <li>titre_art (titre de l'article)</li>
                    <li>datecreation_art (date de création de l'article)</li>
                </ul>
            </div>

            <h3>Structure détaillée des tables</h3>
            
            <table>
                <thead>
                    <tr>
                        <th>Table UTILISATEUR</th>
                        <th>Type</th>
                        <th>Contraintes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="primary-key">id_utilisateur</span></td>
                        <td>Entier</td>
                        <td class="constraint">Clé primaire, Auto-incrémentée</td>
                    </tr>
                    <tr>
                        <td>nom_uti</td>
                        <td>Chaîne(50)</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>prenom_uti</td>
                        <td>Chaîne(50)</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>email_uti</td>
                        <td>Chaîne(100)</td>
                        <td class="constraint">Unique, Non nul</td>
                    </tr>
                    <tr>
                        <td>motdepasse_uti</td>
                        <td>Chaîne(255)</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>dateinscription_uti</td>
                        <td>Date</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>actif_uti</td>
                        <td>Booléen</td>
                        <td class="constraint">Défaut : TRUE</td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>Table ARTICLE</th>
                        <th>Type</th>
                        <th>Contraintes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="primary-key">id_article</span></td>
                        <td>Entier</td>
                        <td class="constraint">Clé primaire, Auto-incrémentée</td>
                    </tr>
                    <tr>
                        <td>titre_art</td>
                        <td>Chaîne(200)</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>contenu_art</td>
                        <td>Texte</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>datecreation_art</td>
                        <td>Date/Heure</td>
                        <td class="constraint">Non nul</td>
                    </tr>
                    <tr>
                        <td>datemodification_art</td>
                        <td>Date/Heure</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>publie_art</td>
                        <td>Booléen</td>
                        <td class="constraint">Défaut : TRUE</td>
                    </tr>
                    <tr>
                        <td>nombrevues_art</td>
                        <td>Entier</td>
                        <td class="constraint">Défaut : 0</td>
                    </tr>
                    <tr>
                        <td><span class="foreign-key">#id_utilisateur</span></td>
                        <td>Entier</td>
                        <td class="constraint">Clé étrangère, Non nul</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="mpd" class="merise-level">
            <h2>Niveau physique (MPD)</h2>
            
            <div class="definition">
                <strong>Niveau physique :</strong> Le MLD est adapté au SGBD choisi (ici MySQL) avec les types de données spécifiques, les contraintes d'intégrité, les index et les optimisations de performance.
            </div>

            <h3>Script de création MySQL</h3>
            
            <div class="sql-code">
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blog;

-- Suppression des tables si elles existent (ordre important pour les FK)
DROP TABLE IF EXISTS blog;
DROP TABLE IF EXISTS user;
            </div>

            <div class="sql-code">
-- Table USER (correspond à UTILISATEUR en Merise)
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATE NOT NULL,
    actif BOOLEAN DEFAULT TRUE,
    
    -- Index pour optimiser les requêtes
    INDEX idx_email (email),
    INDEX idx_actif (actif),
    INDEX idx_date_inscription (date_inscription)
) ENGINE=InnoDB;
            </div>

            <div class="sql-code">
-- Table BLOG (correspond à ARTICLE en Merise)
CREATE TABLE blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(200) NOT NULL,
    contenu TEXT NOT NULL,
    date_creation DATETIME NOT NULL,
    date_modification DATETIME NULL,
    auteur_id INT NOT NULL,
    publie BOOLEAN DEFAULT TRUE,
    nombre_vues INT DEFAULT 0,
    
    -- Contrainte d'intégrité référentielle
    FOREIGN KEY (auteur_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    
    -- Index pour optimiser les requêtes
    INDEX idx_auteur (auteur_id),
    INDEX idx_publie (publie),
    INDEX idx_date_creation (date_creation),
    INDEX idx_nombre_vues (nombre_vues),
    FULLTEXT INDEX idx_recherche (titre, contenu)
) ENGINE=InnoDB;
            </div>

            <h3>Adaptations au niveau physique</h3>
            
            <div class="alert alert-info">
                <strong>Adaptations effectuées :</strong>
                <ul>
                    <li><strong>Nommage :</strong> Simplification des noms (user au lieu d'utilisateur, auteur_id au lieu d'id_utilisateur)</li>
                    <li><strong>Types MySQL :</strong> VARCHAR, TEXT, DATETIME, BOOLEAN, INT</li>
                    <li><strong>Moteur :</strong> InnoDB pour les contraintes d'intégrité</li>
                    <li><strong>Encodage :</strong> UTF8MB4 pour supporter tous les caractères Unicode</li>
                    <li><strong>Index :</strong> Optimisation des requêtes fréquentes</li>
                    <li><strong>FULLTEXT :</strong> Recherche dans le contenu des articles</li>
                    <li><strong>Contraintes FK :</strong> CASCADE pour la cohérence des données</li>
                </ul>
            </div>

            <h3>Insertion des données de test</h3>
            
            <div class="sql-code">
-- Insertion des utilisateurs
INSERT INTO user (nom, prenom, email, mot_de_passe, date_inscription, actif) VALUES
('Dupont', 'Marie', 'marie.dupont@email.com', 'motdepasse123', '2024-01-15', TRUE),
('Martin', 'Pierre', 'pierre.martin@email.com', 'password456', '2024-02-20', TRUE),
('Dubois', 'Sophie', 'sophie.dubois@email.com', 'secret789', '2024-03-10', TRUE),
('Moreau', 'Jean', 'jean.moreau@email.com', 'mdp2024', '2024-04-05', FALSE);
            </div>

            <div class="sql-code">
-- Insertion des articles
INSERT INTO blog (titre, contenu, date_creation, date_modification, auteur_id, publie, nombre_vues) VALUES
('Bienvenue sur notre blog', 'Premier article de notre blog...', '2024-01-20 10:30:00', '2024-01-20 10:30:00', 1, TRUE, 125),
('Les bases de la programmation', 'La programmation demande patience...', '2024-02-15 14:45:00', '2024-02-16 09:20:00', 2, TRUE, 89),
('Recette de cookies', 'Voici ma recette favorite...', '2024-03-02 16:20:00', NULL, 3, TRUE, 256);
            </div>
        </section>

        <section id="dictionnaire" class="merise-level">
            <h2>Dictionnaire des données</h2>
            
            <div class="definition">
                <strong>Dictionnaire des données :</strong> Document recensant tous les attributs du système avec leur signification, leur type et leurs contraintes. C'est la base de l'analyse Merise.
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Attribut</th>
                        <th>Signification</th>
                        <th>Type</th>
                        <th>Taille</th>
                        <th>Contraintes</th>
                        <th>Entité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="primary-key">id_utilisateur</td>
                        <td>Identifiant unique de l'utilisateur</td>
                        <td>Entier</td>
                        <td>-</td>
                        <td>Clé primaire, Auto-incrémenté</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td>nom_uti</td>
                        <td>Nom de famille de l'utilisateur</td>
                        <td>Texte</td>
                        <td>50</td>
                        <td>Obligatoire</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td>prenom_uti</td>
                        <td>Prénom de l'utilisateur</td>
                        <td>Texte</td>
                        <td>50</td>
                        <td>Obligatoire</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td>email_uti</td>
                        <td>Adresse email de l'utilisateur</td>
                        <td>Texte</td>
                        <td>100</td>
                        <td>Obligatoire, Unique</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td>motdepasse_uti</td>
                        <td>Mot de passe chiffré</td>
                        <td>Texte</td>
                        <td>255</td>
                        <td>Obligatoire</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td>dateinscription_uti</td>
                        <td>Date d'inscription sur la plateforme</td>
                        <td>Date</td>
                        <td>-</td>
                        <td>Obligatoire</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td>actif_uti</td>
                        <td>Statut du compte utilisateur</td>
                        <td>Booléen</td>
                        <td>-</td>
                        <td>Défaut : Vrai</td>
                        <td>UTILISATEUR</td>
                    </tr>
                    <tr>
                        <td class="primary-key">id_article</td>
                        <td>Identifiant unique de l'article</td>
                        <td>Entier</td>
                        <td>-</td>
                        <td>Clé primaire, Auto-incrémenté</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td>titre_art</td>
                        <td>Titre de l'article</td>
                        <td>Texte</td>
                        <td>200</td>
                        <td>Obligatoire</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td>contenu_art</td>
                        <td>Contenu de l'article</td>
                        <td>Texte long</td>
                        <td>Illimitée</td>
                        <td>Obligatoire</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td>datecreation_art</td>
                        <td>Date et heure de création</td>
                        <td>Date/Heure</td>
                        <td>-</td>
                        <td>Obligatoire</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td>datemodification_art</td>
                        <td>Date et heure de dernière modification</td>
                        <td>Date/Heure</td>
                        <td>-</td>
                        <td>Facultatif</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td>publie_art</td>
                        <td>Statut de publication de l'article</td>
                        <td>Booléen</td>
                        <td>-</td>
                        <td>Défaut : Vrai</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td>nombrevues_art</td>
                        <td>Nombre de fois où l'article a été lu</td>
                        <td>Entier</td>
                        <td>-</td>
                        <td>Défaut : 0</td>
                        <td>ARTICLE</td>
                    </tr>
                    <tr>
                        <td class="foreign-key">#id_utilisateur</td>
                        <td>Référence vers l'auteur de l'article</td>
                        <td>Entier</td>
                        <td>-</td>
                        <td>Clé étrangère, Obligatoire</td>
                        <td>ARTICLE</td>
                    </tr>
                </tbody>
            </table>

            <h3>Règles de gestion identifiées</h3>
            
            <div class="example">
                <strong>Règles de gestion du système blog :</strong>
                <ol>
                    <li>Un utilisateur doit avoir un email unique dans le système</li>
                    <li>Un utilisateur peut écrire zéro, un ou plusieurs articles</li>
                    <li>Un article est écrit par un et un seul utilisateur</li>
                    <li>Un article peut être publié ou en brouillon</li>
                    <li>La date de création d'un article est obligatoire</li>
                    <li>La date de modification est facultative (nulle si jamais modifié)</li>
                    <li>Le nombre de vues est initialisé à zéro</li>
                    <li>Un utilisateur inactif peut conserver ses articles</li>
                    <li>La suppression d'un utilisateur entraîne la suppression de ses articles</li>
                </ol>
            </div>
        </section>

        <div class="section">
            <h2>Validation et vérifications</h2>
            
            <h3>Vérification des formes normales</h3>
            
            <div class="alert alert-info">
                <strong>1ère forme normale (1FN) :</strong> ✅ Tous les attributs sont atomiques (pas de valeurs multiples)
            </div>
            
            <div class="alert alert-info">
                <strong>2ème forme normale (2FN) :</strong> ✅ Tous les attributs non-clés dépendent entièrement de la clé primaire
            </div>
            
            <div class="alert alert-info">
                <strong>3ème forme normale (3FN) :</strong> ✅ Aucun attribut non-clé ne dépend d'un autre attribut non-clé
            </div>

            <h3>Requêtes de validation</h3>
            
            <div class="sql-code">
-- Vérifier l'intégrité référentielle
SELECT b.titre, u.nom, u.prenom 
FROM blog b 
JOIN user u ON b.auteur_id = u.id;

-- Vérifier les contraintes d'unicité
SELECT email, COUNT(*) 
FROM user 
GROUP BY email 
HAVING COUNT(*) > 1;

-- Statistiques de validation
SELECT 
    (SELECT COUNT(*) FROM user) AS total_utilisateurs,
    (SELECT COUNT(*) FROM user WHERE actif = TRUE) AS utilisateurs_actifs,
    (SELECT COUNT(*) FROM blog) AS total_articles,
    (SELECT COUNT(*) FROM blog WHERE publie = TRUE) AS articles_publies;
            </div>

            <h3>Évolutions possibles</h3>
            
            <div class="example">
                <strong>Extensions possibles du modèle :</strong>
                <ul>
                    <li><strong>Catégories :</strong> Ajouter une entité CATEGORIE avec relation N-M avec ARTICLE</li>
                    <li><strong>Commentaires :</strong> Nouvelle entité COMMENTAIRE liée à ARTICLE et UTILISATEUR</li>
                    <li><strong>Tags :</strong> Système d'étiquetage avec relation N-M</li>
                    <li><strong>Médias :</strong> Gestion des images et fichiers joints</li>
                    <li><strong>Rôles :</strong> Différenciation admin/rédacteur/lecteur</li>
                    <li><strong>Historique :</strong> Versioning des articles</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <h2>Conclusion</h2>
            
            <p>La méthode Merise nous a permis de concevoir méthodiquement notre base de données blog en passant par trois niveaux :</p>
            
            <div class="definition">
                <strong>MCD → MLD → MPD</strong>
                <br><br>
                Du conceptuel (entités UTILISATEUR et ARTICLE avec association ÉCRIRE) au logique (tables avec clés étrangères) puis au physique (script SQL MySQL optimisé).
            </div>
            
            <p>Cette approche garantit :</p>
            <ul>
                <li>La <strong>cohérence</strong> des données (contraintes d'intégrité)</li>
                <li>La <strong>performance</strong> (index appropriés)</li>
                <li>La <strong>maintenabilité</strong> (structure claire et documentée)</li>
                <li>L'<strong>évolutivité</strong> (possibilité d'extensions)</li>
            </ul>
            
            <div class="alert alert-info">
                <strong>Résultat final :</strong> Une base de données relationnelle normalisée, optimisée pour MySQL, respectant toutes les règles de gestion identifiées et prête pour un système de blog professionnel.
            </div>
        </div>
    </div>

    <script>
        // Smooth scrolling pour la navigation
        document.querySelectorAll('.navigation a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });

        // Highlight de la section active
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navigation a');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.style.backgroundColor = '';
                if (link.getAttribute('href') === '#' + current) {
                    link.style.backgroundColor = '#3498db';
                }
            });
        });

        console.log('Documentation Merise chargée - Base de données Blog');
    </script>
</body>
</html>