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

df = df[[
    "game_id", "category"
]]

# print(df)

#get the csv of categories (the row)
print(len(df.index))

#select string to pull all the different types of categories
select_string = "SELECT * FROM Categories"
cursor.execute(select_string)

#fetch all rows from the cursor into a list
results = cursor.fetchall()

#hold the final tuples to insert into the database
final_insert = []

#loop through each row in the dataframe 
for x in range(3500):
    #get the specific row we want, and split the list of categories
    specific_row = df.iloc[x]
    listOfCategories = specific_row["category"].split(", ")

    #for each category, loop through the tuples of category types
    for category in listOfCategories:
        for tup in results:
            #if the catagory name matches, then add the to the final_insert the game_id and cat_id to associate
            if category == tup[1]:
                final_insert.append(tuple((specific_row["game_id"].item(), tup[0])))
                

# for thing in final_insert:
#     print(thing)
   

#final insert query
insert_query = """
INSERT INTO HasCategory (
    game_id, cat_id
) VALUES (%s, %s)
"""

for x in final_insert:
    cursor.execute(insert_query, x)
    conn.commit()

# Close connection
cursor.close()
conn.close()

print("Import completed successfully!")
