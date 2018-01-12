import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from sqlalchemy import create_engine
from sklearn.cluster import KMeans
from sklearn.decomposition import PCA
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from wordcloud import WordCloud

# Accès BDD

engine = create_engine('mysql+pymysql://root:@localhost:3306/rc2?charset=utf8mb4', echo=True)

# Récupération données

food = pd.read_sql_query("SELECT p.`index`, p.generic_name, f.`index`, f.carbohydrates_100g, f.energy_100g, f.proteins_100g, f.fiber_100g, f.sodium_100g, f.salt_100g, f.fat_100g, f.`nutrition-score-fr_100g`, f.sugars_100g, f.`saturated-fat_100g` FROM finals_products f INNER JOIN products p ON f.`index` = p.`index`", con=engine, index_col="index")

# Garde les colonnes numériques (ingrédients)

food2 = food.iloc[:, 3:]

# Réduction de dimensions

reduced_data = PCA(n_components=2).fit_transform(food2)

# Nombre de cluster

n_clust = 7

# Application de Kmeans pour le clustering

km = KMeans(n_clusters=n_clust)
km.fit(reduced_data)
labels = km.labels_
centroids = km.cluster_centers_

stop_words = set(stopwords.words('french'))

# Génère le wordcloud pour chaque cluster
for i in range(n_clust):
    
    food3 = food.iloc[np.where(labels == i)]
    
    text3 = food3['generic_name'].str.lower().str.split()
    
    res = ''
    for index, row in food3.iterrows():
        if row['generic_name'] != 'Unknown':
            res = res + row['generic_name']

    if res == '':
        continue
            
    word_tokens = word_tokenize(res)
    filtered_sentence = [w for w in word_tokens if not w in stop_words]

    final = " ".join(str(x) for x in filtered_sentence)
    # print(final)
    wordcloud2 = WordCloud().generate(final)
    # Generate plot
    plt.imshow(wordcloud2)
    plt.axis("off")
    #plt.show()
    plt.savefig('../data/00' + str(i+1) + '.png', transparent=True)