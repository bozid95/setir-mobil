# 💰 Finance Only - Simplified Payment System

## 📋 **How to Use the Simple Finance System**

### **1. Adding Any Payment**

```
1. Go to Students → Select Student → Finances Tab
2. Click "Add New Payment"
3. Fill in:
   - Date: Payment creation date
   - Type: tuition/registration/material/exam/certificate/penalty
   - Amount: Payment amount in IDR
   - Due Date: When payment should be paid
   - Status: pending/paid/cancelled
   - Description: Additional details
4. Save
```

### **2. Creating Installment Plan**

```
1. Go to Students → Select Student → Finances Tab
2. Click "Add New Payment"
3. Fill in basic info (Date, Type, Description)
4. Select "Installment Payment" mode
5. Enter total amount (e.g., 4,000,000)
6. Set number of installments (e.g., 4)
7. Set first due date
8. Save → System creates 4 records automatically
```

### **3. Marking Payments as Paid**

```
1. In Finances table, find pending payment
2. Click "Mark as Paid" action
3. Confirm → Status changes to paid, payment_date recorded
```

### **4. Understanding Finance Records**

#### **Full Payment**

-   `installment_number = 0`
-   `parent_finance_id = null`
-   Display: "tuition" (just the type)

#### **Installment Records**

-   Parent: `amount = 0`, `installment_number = 0`
-   Child 1: `amount = 1,000,000`, `installment_number = 1`, `parent_finance_id = parent.id`
-   Child 2: `amount = 1,000,000`, `installment_number = 2`, `parent_finance_id = parent.id`
-   Display: "tuition 1/4", "tuition 2/4", etc.

### **5. Finance Dashboard Widgets**

#### **Stats Overview**

-   **Total Revenue**: Sum of all Finance amounts
-   **Completed Payments**: Sum of paid Finance records
-   **Pending Payments**: Sum of pending Finance records
-   **Overdue Payments**: Sum of pending past due_date

#### **Payment Status Chart**

-   Doughnut chart: Paid (green), Pending (yellow), Overdue (red)

#### **Monthly Finance Chart**

-   Line chart showing revenue trends by month

#### **Recent Payments**

-   Last 10 paid Finance records with details

#### **Overdue Payments**

-   All pending payments past due_date
-   Shows days overdue
-   Reminder action available

### **6. Payment Types Available**

-   `tuition` → Tuition Fee
-   `registration` → Registration Fee
-   `material` → Material Fee
-   `exam` → Exam Fee
-   `certificate` → Certificate Fee
-   `penalty` → Penalty

### **7. Payment Status**

-   `pending` → Awaiting payment (yellow badge)
-   `paid` → Payment completed (green badge)
-   `cancelled` → Payment cancelled (red badge)

## 🎯 **Best Practices**

### **For Registration Fees**

```
Type: registration
Mode: Full Payment
Amount: 500,000
Status: pending (until actually paid)
```

### **For Tuition Fees**

```
Type: tuition
Mode: Installment Payment
Total: 4,000,000
Installments: 4
First Due: Next month
```

### **For Additional Fees**

```
Type: material/exam/certificate
Mode: Full Payment
Amount: As needed
Status: pending
```

## 📊 **Reporting Benefits**

1. **Single Source**: All payment data in Finance table
2. **Flexible Queries**: Easy to filter by type, status, dates
3. **Installment Tracking**: Each installment tracked separately
4. **Revenue Analysis**: Monthly/yearly trends visible
5. **Overdue Management**: Automatic overdue detection

## 🔄 **Data Migration Notes**

If migrating from old Finance + Installments system:

1. Keep existing Finance records as-is
2. Convert Installment records to Finance records
3. Set appropriate `installment_number` and `parent_finance_id`
4. Remove old Installments table after verification

---

**🎉 The Finance Only system is now ready for production use!**
