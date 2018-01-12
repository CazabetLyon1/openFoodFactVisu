import pandas as pd
from sqlalchemy import create_engine

# Chargement données source de base

RawData_Nutri = pd.read_csv('../data/en.openfoodfacts.org.products.csv', sep='\t')

# Listes des colonnes retenus

l = ['product_name', 'generic_name', 'image_url', 'image_small_url', 'brands_tags', 'countries_tags', 'ingredients_text', 'ingredients_from_palm_oil_n',
     'nutrition_grade_fr',
     'energy_100g', 'sodium_100g', 'vitamin-a_100g',
     'vitamin-c_100g', 'cholesterol_100g', 'carbohydrates_100g', 'proteins_100g',
     'calcium_100g', 'salt_100g', 'sugars_100g',
     'trans-fat_100g', 'fiber_100g', 'fat_100g', 'magnesium_100g',
     'zinc_100g', 'iron_100g',
     'saturated-fat_100g', 'nutrition-score-fr_100g']

# Garde les produits d'origine France

petite_donnees = RawData_Nutri[l]
petite_donnees = petite_donnees.loc[lambda df: df.countries_tags == 'en:france']

# Remplace les NaN par des 'Unknown' pour les valeur alphabétique

head = ['product_name', 'generic_name',
        'brands_tags', 'countries_tags', 'ingredients_text',
        'nutrition_grade_fr']

for i in range(len(head)):
    petite_donnees[head[i]].fillna("Unknown", inplace=True)

# Remplace les NaN par des 0 pour les valeurs numérique

head = list(petite_donnees.head(1))

for i in range(len(head)):
    petite_donnees[head[i]].fillna(0, inplace=True)

# Garde les lignes numériques (ingrédients) qui sont différents de zéro

petite_donnees = petite_donnees[(petite_donnees.iloc[:, 9:].T != 0).any()]

# Reinitialise les index des données

petite_donnees = petite_donnees.reset_index(drop=True)

# Exporte les produits dans la base de données

engine = create_engine('mysql+pymysql://root:@localhost:3306/rc2?charset=utf8mb4', echo=True)
petite_donnees.to_sql(name='products', con=engine, if_exists='replace', index=True)
