const propertiesData = [
  {
    id: 1,
    title: "Modern Luxury Villa",
    location: "Beverly Hills, CA",
    city: "Los Angeles",
    type: "Villa",
    purpose: "buy",
    price: 8500000,
    bedrooms: 5,
    bathrooms: 6,
    area: 7500,
    yearBuilt: 2022,
    description: "A stunning, ultra-luxurious modern architectural home with large glass windows, an infinity pool, and panoramic views of the city. Featuring a state-of-the-art kitchen, smart home technology, and a private cinema.",
    features: ["Infinity Pool", "Smart Home", "Home Theater", "Wine Cellar", "3-Car Garage"],
    images: [
      "assets/images/hero_property_1786339547369.png",
      "assets/images/luxury_villa_1786339560928.png",
      "assets/images/penthouse_interior_1786339582396.png"
    ],
    agent: {
      name: "Sarah Jenkins",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 123-4567"
    },
    featured: true
  },
  {
    id: 2,
    title: "Downtown Penthouse",
    location: "Manhattan, NY",
    city: "New York",
    type: "Apartment",
    purpose: "buy",
    price: 12400000,
    bedrooms: 4,
    bathrooms: 4.5,
    area: 4200,
    yearBuilt: 2018,
    description: "Spectacular penthouse in the heart of Manhattan featuring floor-to-ceiling windows, a private rooftop terrace, and exquisite modern finishes.",
    features: ["Rooftop Terrace", "Doorman", "Fitness Center", "City Views"],
    images: [
      "assets/images/penthouse_interior_1786339582396.png",
      "assets/images/hero_property_1786339547369.png"
    ],
    agent: {
      name: "Michael Chen",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 987-6543"
    },
    featured: true
  },
  {
    id: 3,
    title: "Ocean View Estate",
    location: "Malibu, CA",
    city: "Los Angeles",
    type: "House",
    purpose: "buy",
    price: 15500000,
    bedrooms: 6,
    bathrooms: 7,
    area: 9000,
    yearBuilt: 2020,
    description: "Private beachfront estate with direct access to the ocean. Incredible outdoor living spaces, guest house, and custom imported materials throughout.",
    features: ["Beach Access", "Guest House", "Outdoor Kitchen", "Spa"],
    images: [
      "assets/images/luxury_villa_1786339560928.png",
      "assets/images/hero_property_1786339547369.png"
    ],
    agent: {
      name: "Sarah Jenkins",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 123-4567"
    },
    featured: true
  },
  {
    id: 4,
    title: "Contemporary Family Home",
    location: "Austin, TX",
    city: "Austin",
    type: "House",
    purpose: "buy",
    price: 2100000,
    bedrooms: 4,
    bathrooms: 3,
    area: 3200,
    yearBuilt: 2019,
    description: "Beautiful modern family home in a highly sought-after neighborhood. Open floor plan, large backyard, and excellent school district.",
    features: ["Large Backyard", "Open Plan", "Gourmet Kitchen"],
    images: [
      "assets/images/hero_property_1786339547369.png"
    ],
    agent: {
      name: "Emma Davis",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 333-2222"
    },
    featured: false
  },
  {
    id: 5,
    title: "Luxury City Residence",
    location: "River North, Chicago",
    city: "Chicago",
    type: "Condo",
    purpose: "buy",
    price: 1850000,
    bedrooms: 3,
    bathrooms: 2.5,
    area: 2400,
    yearBuilt: 2015,
    description: "Elegant condo offering stunning river and city views. Full-service building with top-tier amenities.",
    features: ["Concierge", "Pool", "Gym", "Balcony"],
    images: [
      "assets/images/penthouse_interior_1786339582396.png"
    ],
    agent: {
      name: "Michael Chen",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 987-6543"
    },
    featured: true
  },
  {
    id: 6,
    title: "Private Garden Villa",
    location: "Coral Gables, FL",
    city: "Miami",
    type: "Villa",
    purpose: "buy",
    price: 5200000,
    bedrooms: 5,
    bathrooms: 5,
    area: 5100,
    yearBuilt: 2008,
    description: "Mediterranean-style villa surrounded by lush tropical landscaping. Features a resort-style pool and elegant interior finishes.",
    features: ["Tropical Garden", "Resort Pool", "Outdoor Dining"],
    images: [
      "assets/images/luxury_villa_1786339560928.png"
    ],
    agent: {
      name: "Emma Davis",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 333-2222"
    },
    featured: true
  },
  {
    id: 7,
    title: "Sleek Urban Loft",
    location: "SoHo, NY",
    city: "New York",
    type: "Apartment",
    purpose: "rent",
    price: 8500, // Monthly
    bedrooms: 2,
    bathrooms: 2,
    area: 1800,
    yearBuilt: 1920,
    description: "Authentic SoHo loft with exposed brick, massive windows, and high ceilings. Completely renovated with high-end appliances.",
    features: ["Exposed Brick", "High Ceilings", "In-unit Washer/Dryer"],
    images: [
      "assets/images/penthouse_interior_1786339582396.png"
    ],
    agent: {
      name: "Michael Chen",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 987-6543"
    },
    featured: false
  },
  {
    id: 8,
    title: "Executive Office Space",
    location: "Financial District, SF",
    city: "San Francisco",
    type: "Commercial",
    purpose: "rent",
    price: 15000, // Monthly
    bedrooms: 0,
    bathrooms: 4,
    area: 5000,
    yearBuilt: 2010,
    description: "Premium office space in a Class A building. Features private offices, a large conference room, and break area with views of the bay.",
    features: ["Class A Building", "Bay Views", "Conference Room", "24/7 Access"],
    images: [
      "assets/images/agent_office_1786339595128.png"
    ],
    agent: {
      name: "Sarah Jenkins",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 123-4567"
    },
    featured: false
  },
  {
    id: 9,
    title: "Suburban Retreat",
    location: "Bellevue, WA",
    city: "Seattle",
    type: "House",
    purpose: "buy",
    price: 2800000,
    bedrooms: 4,
    bathrooms: 3.5,
    area: 3800,
    yearBuilt: 2016,
    description: "Peaceful home nestled in nature with easy access to the city. Features a custom kitchen and a large deck for entertaining.",
    features: ["Wooded Lot", "Large Deck", "Custom Kitchen"],
    images: [
      "assets/images/hero_property_1786339547369.png"
    ],
    agent: {
      name: "Emma Davis",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 333-2222"
    },
    featured: false
  },
  {
    id: 10,
    title: "Boutique Retail Space",
    location: "Melrose Ave, LA",
    city: "Los Angeles",
    type: "Commercial",
    purpose: "rent",
    price: 12000, // Monthly
    bedrooms: 0,
    bathrooms: 1,
    area: 1200,
    yearBuilt: 1985,
    description: "High foot-traffic retail location perfect for a boutique or cafe. Excellent street visibility.",
    features: ["Street Frontage", "High Visibility", "Renovated Interior"],
    images: [
      "assets/images/luxury_villa_1786339560928.png"
    ],
    agent: {
      name: "Sarah Jenkins",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 123-4567"
    },
    featured: false
  },
  {
    id: 11,
    title: "Mountain View Estate",
    location: "Aspen, CO",
    city: "Aspen",
    type: "Villa",
    purpose: "buy",
    price: 18500000,
    bedrooms: 6,
    bathrooms: 8,
    area: 11000,
    yearBuilt: 2021,
    description: "Ski-in/ski-out luxury estate with breathtaking mountain views. Includes an indoor pool, spa, and massive stone fireplaces.",
    features: ["Ski-in/Ski-out", "Indoor Pool", "Home Spa", "Wine Room"],
    images: [
      "assets/images/hero_property_1786339547369.png"
    ],
    agent: {
      name: "Michael Chen",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 987-6543"
    },
    featured: true
  },
  {
    id: 12,
    title: "Modern Minimalist Condo",
    location: "Downtown, Miami",
    city: "Miami",
    type: "Condo",
    purpose: "rent",
    price: 5500, // Monthly
    bedrooms: 2,
    bathrooms: 2,
    area: 1400,
    yearBuilt: 2019,
    description: "Sleek and modern condo in the heart of downtown. Wraparound balcony and floor-to-ceiling glass.",
    features: ["Wraparound Balcony", "Smart Tech", "Building Gym"],
    images: [
      "assets/images/penthouse_interior_1786339582396.png"
    ],
    agent: {
      name: "Emma Davis",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 333-2222"
    },
    featured: false
  },
  {
    id: 13,
    title: "Historic Townhouse",
    location: "Beacon Hill, MA",
    city: "Boston",
    type: "House",
    purpose: "buy",
    price: 4100000,
    bedrooms: 4,
    bathrooms: 3.5,
    area: 3100,
    yearBuilt: 1890,
    description: "Beautifully preserved historic townhouse with modern updates. Features original crown molding, fireplaces, and a private courtyard.",
    features: ["Historic Details", "Private Courtyard", "Fireplaces"],
    images: [
      "assets/images/luxury_villa_1786339560928.png"
    ],
    agent: {
      name: "Sarah Jenkins",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 123-4567"
    },
    featured: false
  },
  {
    id: 14,
    title: "Seaside Apartment",
    location: "Santa Monica, CA",
    city: "Los Angeles",
    type: "Apartment",
    purpose: "rent",
    price: 7200, // Monthly
    bedrooms: 2,
    bathrooms: 2,
    area: 1600,
    yearBuilt: 2014,
    description: "Steps from the beach, this bright apartment offers ocean breezes and sunset views from a private balcony.",
    features: ["Ocean View", "Balcony", "Gated Parking"],
    images: [
      "assets/images/penthouse_interior_1786339582396.png"
    ],
    agent: {
      name: "Michael Chen",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 987-6543"
    },
    featured: false
  },
  {
    id: 15,
    title: "Sprawling Ranch",
    location: "Scottsdale, AZ",
    city: "Phoenix",
    type: "House",
    purpose: "buy",
    price: 3500000,
    bedrooms: 5,
    bathrooms: 4,
    area: 6000,
    yearBuilt: 2005,
    description: "Single-story ranch home on 2 acres of land. Features a massive outdoor entertaining area with pool and desert views.",
    features: ["2 Acres", "Pool", "Outdoor Kitchen", "Guest Casita"],
    images: [
      "assets/images/luxury_villa_1786339560928.png"
    ],
    agent: {
      name: "Emma Davis",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+1 (555) 333-2222"
    },
    featured: false
  },
  {
    id: 16,
    title: "Luxury Beachfront Villa",
    location: "Mount Lavinia, Colombo",
    city: "Colombo",
    type: "Villa",
    rental_type: "short_term",
    purpose: "rent",
    nightly_rate: 250,
    bedrooms: 4,
    bathrooms: 4,
    max_guests: 8,
    area: 3200,
    yearBuilt: 2021,
    description: "Experience the ultimate beachfront luxury with our stunning 4-bedroom villa. Private pool, direct beach access, and full staff including a chef.",
    features: ["Private Pool", "Beach Access", "Chef Included", "Ocean View"],
    images: [
      "assets/images/luxury_villa_1786339560928.png",
      "assets/images/hero_property_1786339547369.png"
    ],
    agent: {
      name: "HYVE Stays",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+94 76 762 8254"
    },
    featured: true
  },
  {
    id: 17,
    title: "City Center Penthouse",
    location: "Colombo 03",
    city: "Colombo",
    type: "Apartment",
    rental_type: "short_term",
    purpose: "rent",
    nightly_rate: 180,
    bedrooms: 2,
    bathrooms: 2,
    max_guests: 4,
    area: 1500,
    yearBuilt: 2023,
    description: "Modern luxury penthouse in the heart of the city. Walking distance to major shopping malls, restaurants, and business centers. Features a rooftop infinity pool.",
    features: ["Infinity Pool", "Gym", "City Views", "Smart Home"],
    images: [
      "assets/images/penthouse_interior_1786339582396.png",
      "assets/images/luxury_villa_1786339560928.png"
    ],
    agent: {
      name: "HYVE Stays",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+94 76 762 8254"
    },
    featured: true
  },
  {
    id: 18,
    title: "Cozy Garden Suite",
    location: "Colombo 07",
    city: "Colombo",
    type: "House",
    rental_type: "short_term",
    purpose: "rent",
    nightly_rate: 85,
    bedrooms: 1,
    bathrooms: 1,
    max_guests: 2,
    area: 600,
    yearBuilt: 2019,
    description: "A peaceful retreat in Colombo's most prestigious neighborhood. Features a private garden patio, kitchenette, and high-speed fiber internet.",
    features: ["Private Garden", "Fiber Internet", "Kitchenette", "Workspace"],
    images: [
      "assets/images/hero_property_1786339547369.png",
      "assets/images/penthouse_interior_1786339582396.png"
    ],
    agent: {
      name: "HYVE Stays",
      image: "assets/images/agent_office_1786339595128.png",
      phone: "+94 76 762 8254"
    },
    featured: false
  }
];
