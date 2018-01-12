import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sqlalchemy import create_engine
from sklearn.cluster import KMeans
from sklearn.decomposition import PCA

# Fonction d'intersection entre deux listes

def intersect(a, b):
    return list(set(a) & set(b))

# Trouve 10 produits autour de chaque centroid

def find_products_near_to_centroid(count, boolPrint):
    tab = [[] for clust in range(n_clust)]

    for j in range(n_clust):
        d = km.transform(reduced_data)[:, j]
        ind = np.argsort(d)[::][:count]

        tab[j] = ind

        if boolPrint:
            for index in ind:
                print(str(j) + " : " + food.get_value(index, 'product_name'))

    return tab

# Accès BDD

engine = create_engine('mysql+pymysql://root:@localhost:3306/rc2?charset=utf8mb4', echo=True)

# Récupération données

food = pd.read_sql_table("finals_products", con=engine, index_col="index")

# Garde les colonnes numériques (ingrédients)

ingredient_list = food.iloc[:, 1:]

# Réduction de dimensions

reduced_data = PCA(n_components=2).fit_transform(ingredient_list)

# Nombre de cluster

n_clust = 7

# Application de Kmeans pour le clustering

km = KMeans(n_clusters=n_clust)
km.fit(reduced_data)
labels = km.labels_
centroids = km.cluster_centers_

# Recherche de produits autour des centroids

tab = find_products_near_to_centroid(10, False)

productsNear = [[] for clust in range(n_clust)]

# Affiche le graphique

for i in range(n_clust):
    # select only data observations with cluster label == i
    ds = reduced_data[intersect(np.array(np.where(labels == i))[0], tab[i])]
    
    # Enleve les données qui sont trop eloigné
    ds = ds[ds[:, 0] < 0.8]
    
    if ds.size == 0:
        continue
    
    productsNear[i] = tab[i]
    
    # plot the data observations
    plt.plot(ds[:, 1], ds[:, 0], 'o')
    # plot the centroids
    lines = plt.plot(centroids[i, 1], centroids[i, 0], 'kx')
    # make the centroid x's bigger
    plt.setp(lines, ms=15.0)
    plt.setp(lines, mew=2.0)
plt.show()

# Supprime les listes vides

productsNear = pd.DataFrame([x for x in productsNear if x != []])

# Export données

productsNear.to_sql(name='productsneartocentroid', con=engine, if_exists = 'replace', index=True)