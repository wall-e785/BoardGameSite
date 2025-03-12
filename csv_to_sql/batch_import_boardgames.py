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
batch_size = 500  # Number of rows per batch

# Connect to MySQL
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()

# Read CSV into a DataFrame
df = pd.read_csv(csv_file)

# Rename columns to lowercase for MySQL compatibility
df.columns = [col.lower().replace(" ", "_") for col in df.columns]

# Select only relevant columns to match the MySQL table schema

# works 1 OBJECTS
df = df[[
    "game_id", "names", "min_players", "max_players", 
    "avg_time", "min_time", "max_time", "year", "avg_rating", "image_url", "age", 
    "owned", "designer"
]]

# WORKS 2 ARTISTS
# df = df[[
#     "artist_role", "artist_prefix", "artist_display_name", "artist_display_bio", 
#     "artist_suffix", "artist_alpha_sort", "artist_nationality", 
#     "artist_begin_date", "artist_end_date", "artist_gender", 
#     "artist_ulan_url", "artist_wikidata_url"
# ]]

# Convert NaN values and empty strings/spaces to None (NULL in MySQL)
# Replace NaN and empty strings with None
df = df.applymap(lambda x: None if pd.isna(x) or (isinstance(x, str) and x.strip() == '') else x)

# SQL Insert Statement (Batch Insert)

# works 1 OBJECTS
insert_query = """
INSERT INTO BoardGames (
    game_id, names, min_players, max_players,
    avg_time, min_time, max_time, year, avg_rating, image_url, age,
    owned, designer
) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
"""

# WORKS 2 ARTISTS
# insert_query = """
# INSERT INTO artists (
#     artist_role, artist_prefix, artist_display_name, artist_display_bio, 
#     artist_suffix, artist_alpha_sort, artist_nationality, 
#     artist_begin_date, artist_end_date, artist_gender, 
#     artist_ulan_url, artist_wikidata_url
# ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
# """


# Process data in batches
total_rows = len(df)
for i in range(0, total_rows, batch_size):
    batch_data = [tuple(row) for row in df.iloc[i:i+batch_size].values]
    
    # Debugging: print a few rows to check data before insertion
    print(batch_data[:5])  # Print first 5 rows of the batch to check
    
    cursor.executemany(insert_query, batch_data)
    conn.commit()  # Commit after each batch
    print(f"Inserted {min(i+batch_size, total_rows)} of {total_rows} rows...")

# Close connection
cursor.close()
conn.close()

print("Batch import completed successfully!")
