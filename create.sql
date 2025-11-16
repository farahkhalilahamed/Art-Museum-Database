-- DROP DATABASE Art_Museum;
CREATE DATABASE Art_Museum;
USE Art_Museum;

CREATE TABLE Artist
	(ArtistID	INT	Default 0,
    AFName VARCHAR(100),
    AMInitial	CHAR(1),
    ALName VARCHAR(100),
    DOB DATE NOT NULL,
    Country VARCHAR(100) NOT NULL,
    Bio VARCHAR(300),
    CONSTRAINT ArtistPK
		PRIMARY KEY (ArtistID)
);

CREATE TABLE Artwork (
	ArtworkID	INT	NOT NULL,
    Title VARCHAR(200) Default 'Untitled',
    YearCreated INT NOT NULL,
    Art_Medium VARCHAR(100) NOT NULL,
    Details VARCHAR(300),
    ArtistID INT NOT NULL,
    CONSTRAINT ArtworkPK
		PRIMARY KEY (ArtworkID),
	CONSTRAINT ArtworkFK
		FOREIGN KEY (ArtistID) REFERENCES Artist(ArtistID)
        ON DELETE RESTRICT
);

CREATE TABLE Employee (
	EmployeeID INT NOT NULL,
    EFName VARCHAR(10) NOT NULL,
    EMInitial CHAR(1),
    ELName VARCHAR(20) NOT NULL,
    Phone BIGINT NOT NULL,
    Email VARCHAR(50) NOT NULL,
    CONSTRAINT EmployeePK
		PRIMARY KEY (EmployeeID)
);

CREATE TABLE Donors (
	DonorID INT NOT NULL,
    DFName VARCHAR(10) NOT NULL,
    DMInitial CHAR(1),
    DLName VARCHAR(20) NOT NULL,
    Amount INT Default 0,
    Message VARCHAR(300) NOT NULL,
    CONSTRAINT DonorsPK
		PRIMARY KEY (DonorID)
);

CREATE TABLE Location (
    LocationID INT NOT NULL,
    Gallery VARCHAR(100),
    Floor INT,
    CONSTRAINT LocationPK PRIMARY KEY (LocationID)
);

CREATE TABLE Exhibition (
	ExhibitionID INT NOT NULL,
    LocationID INT NOT NULL,
    Title VARCHAR(100) NOT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE,
    Description VARCHAR(300),
    CONSTRAINT ExhibitionPK
		PRIMARY KEY (ExhibitionID),
	CONSTRAINT ExhibitionFK
		FOREIGN KEY (LocationID) REFERENCES Location(LocationID)
        ON DELETE CASCADE
);

CREATE TABLE ExhibitionStaff (
    EmployeeID INT NOT NULL,
    ExhibitionID INT NOT NULL,
    CONSTRAINT ExhibitionStaffPK PRIMARY KEY (EmployeeID, ExhibitionID),
    CONSTRAINT ExhibitionStaffEmployeeFK FOREIGN KEY (EmployeeID)
        REFERENCES Employee(EmployeeID)
        ON DELETE CASCADE,
    CONSTRAINT ExhibitionStaffExhibitionFK FOREIGN KEY (ExhibitionID)
        REFERENCES Exhibition(ExhibitionID)
        ON DELETE CASCADE
);

CREATE TABLE Administrator (
    EmployeeID INT NOT NULL,
    ExhibitionID INT NOT NULL,
    Role VARCHAR(20) NOT NULL,
    CONSTRAINT AdministratorPK PRIMARY KEY (EmployeeID, ExhibitionID),
    CONSTRAINT AdministratorEmployeeFK FOREIGN KEY (EmployeeID)
        REFERENCES Employee(EmployeeID)
        ON DELETE CASCADE,
    CONSTRAINT AdministratorExhibitionFK FOREIGN KEY (ExhibitionID)
        REFERENCES Exhibition(ExhibitionID)
        ON DELETE CASCADE
);


CREATE TABLE ExhibitedArtwork (
    ExhibitionID INT NOT NULL,
    ArtworkID INT NOT NULL,
    ArtistID INT NOT NULL,
    CONSTRAINT ExhibitedArtworkPK PRIMARY KEY (ExhibitionID, ArtworkID, ArtistID),
    CONSTRAINT ExhibitedArtworkExhibitionFK FOREIGN KEY (ExhibitionID)
        REFERENCES Exhibition(ExhibitionID)
        ON DELETE CASCADE,
    CONSTRAINT ExhibitedArtworkArtworkFK FOREIGN KEY (ArtworkID)
        REFERENCES Artwork(ArtworkID)
        ON DELETE RESTRICT,
    CONSTRAINT ExhibitedArtworkArtistFK FOREIGN KEY (ArtistID)
        REFERENCES Artist(ArtistID)
        ON DELETE RESTRICT
);

CREATE TABLE ExhibitionDonors (
    ExhibitionID INT NOT NULL,
    DonorID INT NOT NULL,
    CONSTRAINT ExhibitionDonorsPK PRIMARY KEY (ExhibitionID, DonorID),
    CONSTRAINT ExhibitionDonorsExhibitionFK FOREIGN KEY (ExhibitionID)
        REFERENCES Exhibition(ExhibitionID)
        ON DELETE CASCADE,
    CONSTRAINT ExhibitionDonorsDonorFK FOREIGN KEY (DonorID)
        REFERENCES Donors(DonorID)
        ON DELETE RESTRICT
);
