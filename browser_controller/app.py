import webbrowser

def search_input():
    search_terms = []

    while True:
        term = input("Enter the things you want to search, and hit enter after each. Leave empty to initiate search: ") 
        
        if len(term) < 1:
            break
        else:
            search_terms.append(term)
    
    return search_terms


def initiate_search(url, search_terms):
    for term in search_terms:
        search_query = url.format(term)
        webbrowser.open_new_tab(search_query)
    

site = input("""Choose the site/search engine you want to use for your search (type the number key or the name):  
                    1) Google
                    2) Duckduckgo
                    3) Reddit 
                    4) Stack Exchange
            """)

if site == "google" or site == "Google" or site == '1':
    url = "https://www.google.com/search?q={}"
elif site == "duckduckgo" or site == "Duckduckgo" or site == '2':
    url = "https://duckduckgo.com/?q={}"
elif site == "reddit" or site == "Reddit" or site == '3':
    url = "https://www.reddit.com/search/?q={}"
elif site == "Stack Exchange" or site == "stack exchange" or site == "stackexchange" or site == '4':
    url = "https://stackexchange.com/search?q={}"

search_terms = search_input()
initiate_search(url, search_terms)

