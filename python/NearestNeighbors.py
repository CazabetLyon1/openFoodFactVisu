import pandas as pd
from sklearn.neighbors import NearestNeighbors
from sqlalchemy import create_engine

# Accès BDD

engine = create_engine('mysql+pymysql://root:@localhost:3306/rc2?charset=utf8mb4', echo=True)

# Récupération données

food = pd.read_sql_table("finals_products", con=engine, index_col="index")

# Garde les colonnes numériques (ingrédients)

ingredient_list = food.iloc[:, 1:]

# Calcul les 5 plus proches voisins de chaque produits

nbrs = NearestNeighbors(n_neighbors=5, algorithm='auto').fit(ingredient_list)
distances, indices = nbrs.kneighbors(ingredient_list)

# Exportation du résultat dans la base de données

dtIndice = pd.DataFrame(data=indices)
dtIndice.to_sql(name='products_link', con=engine, if_exists = 'replace', index=True)