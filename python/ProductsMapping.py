import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sqlalchemy import create_engine
from sklearn.cluster import KMeans
from sklearn.decomposition import PCA

# Accès BDD

engine = create_engine('mysql+pymysql://root:@localhost:3306/rc2?charset=utf8mb4', echo=True)

# Récupération données

food = pd.read_sql_table("finals_products", con=engine, index_col="index")

# Garde les colonnes numériques (ingrédients)

food = food.iloc[:, 1:]

# Réduction de dimensions

reduced_data = PCA(n_components=2).fit_transform(food)

# Nombre de cluster

n_clust = 7

# Application de Kmeans pour le clustering

km = KMeans(n_clusters=n_clust)
km.fit(reduced_data)
labels = km.labels_
centroids = km.cluster_centers_

# Affiche le graphique

for i in range(n_clust):
    # select only data observations with cluster label == i
    ds = reduced_data[np.where(labels==i)]
    
    # Enleve les données qui sont trop eloigné
    ds = ds[ds[:, 0] < -892225]
    
    if ds.size == 0:
        continue
    
    # plot the data observations
    plt.plot(ds[:,1],ds[:,0],'o')
    # plot the centroids
    lines = plt.plot(centroids[i,1],centroids[i,0],'kx')
    # make the centroid x's bigger
    plt.setp(lines,ms=15.0)
    plt.setp(lines,mew=2.0)

plt.show()