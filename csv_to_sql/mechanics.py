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

mechanics = df['mechanic']

#mechanics = mechanics.applymap(lambda x: None if pd.isna(x) or (isinstance(x, str) and x.strip() == '') else x)



listOfLists = []

for x in mechanics:
    lst = x.split(", ")
    listOfLists.append(lst)


# for x in listOfLists:
#     print(x)

uniqueMechanics = []

for x in listOfLists:
    for y in x:
        if y not in uniqueMechanics:
            uniqueMechanics.append(y)

for x in uniqueMechanics:
    print(x)

insert_query = """
INSERT INTO Mechanics (
    mec_id, mec_name
) VALUES (%s, %s)
"""

# Process data in batches
total_rows = len(uniqueMechanics)

ids = []
counter = 0

listOfTuples = []

for x in uniqueMechanics:
    counter+=1
    #ids.append(counter)
    listOfTuples.append(tuple((counter, x)))

for x in listOfTuples:
    cursor.execute(insert_query, x)
    conn.commit()


# for i in range(0, total_rows, batch_size):
#     batch_data = [uniqueMechanics[i]]
    
#     # Debugging: print a few rows to check data before insertion
#     print(batch_data[:1])  # Print first 5 rows of the batch to check
    
#     cursor.executemany(insert_query, batch_data)
#     conn.commit()  # Commit after each batch
#     print(f"Inserted {min(i+batch_size, total_rows)} of {total_rows} rows...")

# # Close connection
# cursor.close()
# conn.close()

# print("Batch import completed successfully!")
