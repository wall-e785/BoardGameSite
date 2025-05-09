import pandas as pd
import mysql.connector

# Database connection settings
db_config = {
    "host": "localhost",  # Change if using a remote MySQL server
    "user": "root",       # Change if needed
    "password": "",       # Leave empty if using XAMPP (default)
    "database": "boardgames"  # Correct database name
}

# CSV file path
csv_file = "boardgames.csv"  # Correct file name
batch_size = 1  # Number of rows per batch

# Connect to MySQL
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()


df = pd.read_csv(csv_file)

# Rename columns to lowercase for MySQL compatibility
df.columns = [col.lower().replace(" ", "_") for col in df.columns]

categories = df['category']

#mechanics = mechanics.applymap(lambda x: None if pd.isna(x) or (isinstance(x, str) and x.strip() == '') else x)



listOfLists = []

for x in categories:
    lst = x.split(", ")
    listOfLists.append(lst)


# for x in listOfLists:
#     print(x)

uniqueCategories = []

for x in listOfLists:
    for y in x:
        if y not in uniqueCategories:
            uniqueCategories.append(y)

for x in uniqueCategories:
    print(x)

insert_query = """
INSERT INTO Categories (
    cat_id, cat_name
) VALUES (%s, %s)
"""

# Process data in batches
total_rows = len(uniqueCategories)

ids = []
counter = 0

listOfTuples = []

for x in uniqueCategories:
    counter+=1
    #ids.append(counter)
    listOfTuples.append(tuple((counter, x)))

for x in listOfTuples:
    cursor.execute(insert_query, x)
    conn.commit()

