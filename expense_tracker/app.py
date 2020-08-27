import openpyxl as xl
from openpyxl.chart import BarChart, reference 
from datetime import date

def process_workbook(filename):
    workbook = xl.load_workbook(filename)
    sheet = workbook['Sheet1']

    


items = input("Enter the items you bought: ")
totalCost = input("Enter the total cost")
purchaseDate = input("Hit enter if the purchase was made today, otherwise, enter date in MM/DD/YYYY format")

if len(purchaseDate) < 1:
    purchaseDate = date.today()
else: 
    continue

