// Sample data for documents
const documents = [
    {
        id: 1,
        title: "Introduction to Algorithms",
        description: "Comprehensive guide to fundamental algorithms and data structures for computer science students.",
        uploader: "Prof. Smith",
        uploaderId: "prof-smith",
        date: "2025-04-02T14:30:00",
        format: "pdf",
        subject: "algorithms",
        size: "2.4 MB"
    },
    {
        id: 2,
        title: "Python Programming: From Basics to Advanced",
        description: "Complete tutorial covering Python programming from fundamentals to advanced concepts and applications.",
        uploader: "Dr. Jones",
        uploaderId: "dr-jones",
        date: "2025-03-28T09:15:00",
        format: "pdf",
        subject: "programming",
        size: "5.1 MB"
    },
    {
        id: 3,
        title: "Database Systems: Concepts and Design",
        description: "Lecture slides on database management systems, covering SQL, normalization, and database design.",
        uploader: "Prof. Wilson",
        uploaderId: "prof-wilson",
        date: "2025-04-05T16:45:00",
        format: "ppt",
        subject: "databases",
        size: "3.7 MB"
    },
    {
        id: 4,
        title: "Computer Networks: Protocol Stack",
        description: "Detailed notes on networking protocols and architecture used in modern computer networks.",
        uploader: "Prof. Smith",
        uploaderId: "prof-smith",
        date: "2025-03-15T10:00:00",
        format: "doc",
        subject: "networking",
        size: "1.8 MB"
    },
    {
        id: 5,
        title: "Machine Learning Fundamentals",
        description: "Introduction to machine learning concepts, algorithms, and practical implementations.",
        uploader: "Dr. Jones",
        uploaderId: "dr-jones",
        date: "2025-04-08T11:20:00",
        format: "pdf",
        subject: "ai",
        size: "4.5 MB"
    },
    {
        id: 6,
        title: "Web Development with HTML, CSS, and JavaScript",
        description: "Complete guide to front-end web development with code examples and exercises.",
        uploader: "TA Brown",
        uploaderId: "ta-brown",
        date: "2025-04-01T14:00:00",
        format: "code",
        subject: "programming",
        size: "2.2 MB"
    },
    {
        id: 7,
        title: "Cybersecurity Best Practices",
        description: "Comprehensive guide to securing systems, networks, and applications against cyber threats.",
        uploader: "Prof. Wilson",
        uploaderId: "prof-wilson",
        date: "2025-03-20T13:30:00",
        format: "pdf",
        subject: "security",
        size: "3.3 MB"
    },
    {
        id: 8,
        title: "Big Data Analytics",
        description: "Introduction to big data processing, analytics frameworks, and visualization techniques.",
        uploader: "Dr. Jones",
        uploaderId: "dr-jones",
        date: "2025-04-03T15:45:00",
        format: "doc",
        subject: "databases",
        size: "2.9 MB"
    },
    {
        id: 9,
        title: "Operating Systems Concepts",
        description: "Detailed notes on OS architecture, processes, memory management, and file systems.",
        uploader: "Prof. Smith",
        uploaderId: "prof-smith",
        date: "2025-03-10T09:00:00",
        format: "pdf",
        subject: "programming",
        size: "4.2 MB"
    },
    {
        id: 10,
        title: "Data Structures Implementation in C++",
        description: "Code examples and explanations for implementing common data structures in C++.",
        uploader: "TA Brown",
        uploaderId: "ta-brown",
        date: "2025-04-07T16:15:00",
        format: "code",
        subject: "algorithms",
        size: "1.5 MB"
    }
];

// DOM elements
const documentList = document.getElementById('document-list');
const filterForm = document.getElementById('filter-form');
const resetFiltersBtn = document.getElementById('reset-filters');
const searchInput = document.getElementById('search-input');
const searchButton = document.getElementById('search-button');

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    displayDocuments(documents);
    setupEventListeners();
});

// Format date for display
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Display documents in the list
function displayDocuments(docs) {
    documentList.innerHTML = '';
    
    if (docs.length === 0) {
        documentList.innerHTML = `
            <div class="list-group-item p-4 text-center">
                <i class="fas fa-file-circle-xmark fa-3x mb-3 text-muted"></i>
                <h5>No documents found</h5>
                <p class="mb-0">Try adjusting your filters or search query.</p>
            </div>
        `;
        return;
    }
    
    docs.forEach(doc => {
        const formatClass = `format-${doc.format}`;
        const formattedDate = formatDate(doc.date);
        
        const docItem = document.createElement('div');
        docItem.className = 'list-group-item document-item p-3';
        docItem.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="document-title">${doc.title}</h5>
                    <p class="document-description mb-2">${doc.description}</p>
                    <div class="document-meta">
                        <span class="document-format ${formatClass}">${doc.format.toUpperCase()}</span>
                        <span class="document-size">${doc.size}</span> • 
                        Uploaded by <span class="document-uploader">${doc.uploader}</span> • 
                        <span class="document-date">${formattedDate}</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end document-actions">
                    <button class="btn btn-sm btn-download">
                        <i class="fas fa-download me-1"></i> Download
                    </button>
                    <button class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-info-circle"></i> Details
                    </button>
                </div>
            </div>
        `;
        
        documentList.appendChild(docItem);
    });
}

// Filter documents based on form inputs
function filterDocuments() {
    const subjectFilter = document.getElementById('subject-filter').value;
    const authorFilter = document.getElementById('author-filter').value;
    const dateFilter = document.getElementById('date-filter').value;
    const formatFilter = document.getElementById('format-filter').value;
    const searchQuery = searchInput.value.toLowerCase().trim();
    
    let filteredDocs = documents.filter(doc => {
        // Apply subject filter
        if (subjectFilter && doc.subject !== subjectFilter) return false;
        
        // Apply author filter
        if (authorFilter && doc.uploaderId !== authorFilter) return false;
        
        // Apply format filter
        if (formatFilter && doc.format !== formatFilter) return false;
        
        // Apply date filter
        if (dateFilter) {
            const docDate = new Date(doc.date);
            const today = new Date();
            const oneDay = 24 * 60 * 60 * 1000;
            const oneWeek = 7 * oneDay;
            const oneMonth = 30 * oneDay;
            const oneYear = 365 * oneDay;
            
            switch (dateFilter) {
                case 'today':
                    if (today - docDate > oneDay) return false;
                    break;
                case 'week':
                    if (today - docDate > oneWeek) return false;
                    break;
                case 'month':
                    if (today - docDate > oneMonth) return false;
                    break;
                case 'year':
                    if (today - docDate > oneYear) return false;
                    break;
            }
        }
        
        // Apply search query
        if (searchQuery) {
            const titleMatch = doc.title.toLowerCase().includes(searchQuery);
            const descMatch = doc.description.toLowerCase().includes(searchQuery);
            const uploaderMatch = doc.uploader.toLowerCase().includes(searchQuery);
            
            if (!titleMatch && !descMatch && !uploaderMatch) return false;
        }
        
        return true;
    });
    
    // Sort by most recent first
    filteredDocs.sort((a, b) => new Date(b.date) - new Date(a.date));
    
    displayDocuments(filteredDocs);
}

// Setup event listeners
function setupEventListeners() {
    // Apply filters on form submit
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        filterDocuments();
    });
    
    // Reset filters
    resetFiltersBtn.addEventListener('click', function() {
        setTimeout(() => {
            displayDocuments(documents);
        }, 100);
    });
    
    // Search on button click
    searchButton.addEventListener('click', function() {
        filterDocuments();
    });
    
    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            filterDocuments();
        }
    });
    
    // Download button functionality
    documentList.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-download') || e.target.parentElement.classList.contains('btn-download')) {
            e.preventDefault();
            
            // Get closest document item
            const docItem = e.target.closest('.document-item');
            const title = docItem.querySelector('.document-title').textContent;
            
            // Simulate download
            alert(`Downloading "${title}"`);
        }
    });
}