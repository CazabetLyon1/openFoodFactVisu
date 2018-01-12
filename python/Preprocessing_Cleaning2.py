import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sqlalchemy import create_engine
from sklearn.cluster import KMeans
from sklearn.decomposition import PCA

# Accès BDD

engine = create_engine('mysql+pymysql://root:@localhost:3306/rc2?charset=utf8mb4', echo=True)

# Récupération données

food = pd.read_sql_table("products", con=engine, index_col="index")

# Garde les colonnes numériques (ingrédients)

ingredient_list = food.iloc[:, 9:]

# Graphique

plt.figure(figsize=(13, 40))
plt.rcParams['axes.facecolor'] = 'black'
plt.rc('grid', color='#202020')

(ingredient_list.eq(0).mean(axis=0)*100).plot.barh(color ="#FF6600")
plt.xlim(xmax=100)
plt.title("Valeurs à zéro",fontsize=18)
plt.xlabel("Pourcentage",fontsize=14)
plt.show()

# Keep only consistent features (less of 60% zero values)

de = ingredient_list.eq(0).mean(axis=0)
l = []
for i in range(0,len(de)):
    if de[i] < 0.6:
        templist = list(de[de==de[i]].index)
        for i in range (0,len(templist)):
            l.append(templist[i])

variable_consistante = list(set(l))

# Export données

food[variable_consistante].to_sql(name='finals_products', con=engine, if_exists = 'replace', index=True)
