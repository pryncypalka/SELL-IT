--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1

-- Started on 2024-01-29 23:09:22 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3443 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 16480)
-- Name: categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.categories (
    category_id integer NOT NULL,
    category_name character varying(255) NOT NULL
);


ALTER TABLE public.categories OWNER TO docker;

--
-- TOC entry 215 (class 1259 OID 16479)
-- Name: categories_category_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.categories_category_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_category_id_seq OWNER TO docker;

--
-- TOC entry 3444 (class 0 OID 0)
-- Dependencies: 215
-- Name: categories_category_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.categories_category_id_seq OWNED BY public.categories.category_id;


--
-- TOC entry 230 (class 1259 OID 16525)
-- Name: item; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.item (
    item_id integer NOT NULL,
    item_name character varying(255) NOT NULL
);


ALTER TABLE public.item OWNER TO docker;

--
-- TOC entry 229 (class 1259 OID 16524)
-- Name: item_item_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.item_item_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.item_item_id_seq OWNER TO docker;

--
-- TOC entry 3445 (class 0 OID 0)
-- Dependencies: 229
-- Name: item_item_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.item_item_id_seq OWNED BY public.item.item_id;


--
-- TOC entry 231 (class 1259 OID 16547)
-- Name: item_sub; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.item_sub (
    item_id integer NOT NULL,
    sub_id integer NOT NULL
);


ALTER TABLE public.item_sub OWNER TO docker;

--
-- TOC entry 222 (class 1259 OID 16500)
-- Name: subcategories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.subcategories (
    subcategory_id integer NOT NULL,
    category_id integer,
    subcategory_name character varying(255) NOT NULL
);


ALTER TABLE public.subcategories OWNER TO docker;

--
-- TOC entry 234 (class 1259 OID 24758)
-- Name: item_view; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.item_view AS
 SELECT i.item_id,
    i.item_name,
    s.subcategory_name,
    c.category_name
   FROM (((public.item i
     JOIN public.item_sub isub ON ((i.item_id = isub.item_id)))
     JOIN public.subcategories s ON ((isub.sub_id = s.subcategory_id)))
     JOIN public.categories c ON ((s.category_id = c.category_id)));


ALTER VIEW public.item_view OWNER TO docker;

--
-- TOC entry 218 (class 1259 OID 16488)
-- Name: offers; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.offers (
    offer_id integer NOT NULL,
    price numeric(10,2),
    created_at timestamp without time zone NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    user_id integer NOT NULL
);


ALTER TABLE public.offers OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 16487)
-- Name: offers_offer_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.offers_offer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.offers_offer_id_seq OWNER TO docker;

--
-- TOC entry 3446 (class 0 OID 0)
-- Dependencies: 217
-- Name: offers_offer_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.offers_offer_id_seq OWNED BY public.offers.offer_id;


--
-- TOC entry 220 (class 1259 OID 16493)
-- Name: photos; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.photos (
    id_photo integer NOT NULL,
    photo_path character varying(255) NOT NULL,
    offer_id integer
);


ALTER TABLE public.photos OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 16492)
-- Name: photos_id_photo_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.photos_id_photo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.photos_id_photo_seq OWNER TO docker;

--
-- TOC entry 3447 (class 0 OID 0)
-- Dependencies: 219
-- Name: photos_id_photo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.photos_id_photo_seq OWNED BY public.photos.id_photo;


--
-- TOC entry 224 (class 1259 OID 16505)
-- Name: templates; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.templates (
    template_id integer NOT NULL,
    item_id integer,
    user_id integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    created_at timestamp without time zone,
    is_public boolean NOT NULL
);


ALTER TABLE public.templates OWNER TO docker;

--
-- TOC entry 235 (class 1259 OID 24780)
-- Name: public_templates_items; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.public_templates_items AS
 SELECT i.item_id,
    i.item_name,
    s.subcategory_name,
    c.category_name
   FROM ((((public.templates t
     JOIN public.item i ON ((t.item_id = i.item_id)))
     JOIN public.item_sub isub ON ((i.item_id = isub.item_id)))
     JOIN public.subcategories s ON ((isub.sub_id = s.subcategory_id)))
     JOIN public.categories c ON ((s.category_id = c.category_id)))
  WHERE (t.is_public = true);


ALTER VIEW public.public_templates_items OWNER TO docker;

--
-- TOC entry 233 (class 1259 OID 24673)
-- Name: role; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.role (
    id_role integer NOT NULL,
    role_name character varying(255) NOT NULL
);


ALTER TABLE public.role OWNER TO docker;

--
-- TOC entry 232 (class 1259 OID 24672)
-- Name: role_id_role_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.role_id_role_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.role_id_role_seq OWNER TO docker;

--
-- TOC entry 3448 (class 0 OID 0)
-- Dependencies: 232
-- Name: role_id_role_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.role_id_role_seq OWNED BY public.role.id_role;


--
-- TOC entry 221 (class 1259 OID 16499)
-- Name: subcategories_subcategory_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.subcategories_subcategory_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subcategories_subcategory_id_seq OWNER TO docker;

--
-- TOC entry 3449 (class 0 OID 0)
-- Dependencies: 221
-- Name: subcategories_subcategory_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.subcategories_subcategory_id_seq OWNED BY public.subcategories.subcategory_id;


--
-- TOC entry 223 (class 1259 OID 16504)
-- Name: templates_template_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.templates_template_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.templates_template_id_seq OWNER TO docker;

--
-- TOC entry 3450 (class 0 OID 0)
-- Dependencies: 223
-- Name: templates_template_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.templates_template_id_seq OWNED BY public.templates.template_id;


--
-- TOC entry 226 (class 1259 OID 16512)
-- Name: user_details; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.user_details (
    id_user_details integer NOT NULL,
    photo_path character varying(255),
    email character varying(255) NOT NULL
);


ALTER TABLE public.user_details OWNER TO docker;

--
-- TOC entry 225 (class 1259 OID 16511)
-- Name: user_details_id_user_details_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.user_details_id_user_details_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_details_id_user_details_seq OWNER TO docker;

--
-- TOC entry 3451 (class 0 OID 0)
-- Dependencies: 225
-- Name: user_details_id_user_details_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.user_details_id_user_details_seq OWNED BY public.user_details.id_user_details;


--
-- TOC entry 228 (class 1259 OID 16517)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    password_hashed character varying(255) NOT NULL,
    create_time timestamp without time zone NOT NULL,
    id_user_details integer NOT NULL,
    id_role integer NOT NULL
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 227 (class 1259 OID 16516)
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_user_id_seq OWNER TO docker;

--
-- TOC entry 3452 (class 0 OID 0)
-- Dependencies: 227
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- TOC entry 3255 (class 2604 OID 16483)
-- Name: categories category_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories ALTER COLUMN category_id SET DEFAULT nextval('public.categories_category_id_seq'::regclass);


--
-- TOC entry 3262 (class 2604 OID 16528)
-- Name: item item_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.item ALTER COLUMN item_id SET DEFAULT nextval('public.item_item_id_seq'::regclass);


--
-- TOC entry 3256 (class 2604 OID 16491)
-- Name: offers offer_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.offers ALTER COLUMN offer_id SET DEFAULT nextval('public.offers_offer_id_seq'::regclass);


--
-- TOC entry 3257 (class 2604 OID 16496)
-- Name: photos id_photo; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.photos ALTER COLUMN id_photo SET DEFAULT nextval('public.photos_id_photo_seq'::regclass);


--
-- TOC entry 3263 (class 2604 OID 24676)
-- Name: role id_role; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.role ALTER COLUMN id_role SET DEFAULT nextval('public.role_id_role_seq'::regclass);


--
-- TOC entry 3258 (class 2604 OID 16503)
-- Name: subcategories subcategory_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.subcategories ALTER COLUMN subcategory_id SET DEFAULT nextval('public.subcategories_subcategory_id_seq'::regclass);


--
-- TOC entry 3259 (class 2604 OID 16508)
-- Name: templates template_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.templates ALTER COLUMN template_id SET DEFAULT nextval('public.templates_template_id_seq'::regclass);


--
-- TOC entry 3260 (class 2604 OID 16515)
-- Name: user_details id_user_details; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_details ALTER COLUMN id_user_details SET DEFAULT nextval('public.user_details_id_user_details_seq'::regclass);


--
-- TOC entry 3261 (class 2604 OID 16520)
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- TOC entry 3265 (class 2606 OID 16485)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (category_id);


--
-- TOC entry 3279 (class 2606 OID 16530)
-- Name: item item_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.item
    ADD CONSTRAINT item_pkey PRIMARY KEY (item_id);


--
-- TOC entry 3281 (class 2606 OID 16551)
-- Name: item_sub item_sub_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.item_sub
    ADD CONSTRAINT item_sub_pkey PRIMARY KEY (item_id, sub_id);


--
-- TOC entry 3267 (class 2606 OID 16532)
-- Name: offers offers_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.offers
    ADD CONSTRAINT offers_pkey PRIMARY KEY (offer_id);


--
-- TOC entry 3269 (class 2606 OID 16534)
-- Name: photos photos_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.photos
    ADD CONSTRAINT photos_pkey PRIMARY KEY (id_photo);


--
-- TOC entry 3283 (class 2606 OID 24678)
-- Name: role role_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.role
    ADD CONSTRAINT role_pkey PRIMARY KEY (id_role);


--
-- TOC entry 3271 (class 2606 OID 16536)
-- Name: subcategories subcategories_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.subcategories
    ADD CONSTRAINT subcategories_pkey PRIMARY KEY (subcategory_id);


--
-- TOC entry 3273 (class 2606 OID 16538)
-- Name: templates templates_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.templates
    ADD CONSTRAINT templates_pkey PRIMARY KEY (template_id);


--
-- TOC entry 3275 (class 2606 OID 16540)
-- Name: user_details user_details_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.user_details
    ADD CONSTRAINT user_details_pkey PRIMARY KEY (id_user_details);


--
-- TOC entry 3277 (class 2606 OID 16542)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 3286 (class 2606 OID 24729)
-- Name: subcategories cat_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.subcategories
    ADD CONSTRAINT cat_key FOREIGN KEY (category_id) REFERENCES public.categories(category_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3289 (class 2606 OID 24744)
-- Name: users details_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT details_key FOREIGN KEY (id_user_details) REFERENCES public.user_details(id_user_details) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3291 (class 2606 OID 24704)
-- Name: item_sub item_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.item_sub
    ADD CONSTRAINT item_key FOREIGN KEY (item_id) REFERENCES public.item(item_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3287 (class 2606 OID 24734)
-- Name: templates item_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.templates
    ADD CONSTRAINT item_key FOREIGN KEY (item_id) REFERENCES public.item(item_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3285 (class 2606 OID 24724)
-- Name: photos offer_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.photos
    ADD CONSTRAINT offer_key FOREIGN KEY (offer_id) REFERENCES public.offers(offer_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3290 (class 2606 OID 24749)
-- Name: users role_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT role_key FOREIGN KEY (id_role) REFERENCES public.role(id_role) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3292 (class 2606 OID 24709)
-- Name: item_sub sub_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.item_sub
    ADD CONSTRAINT sub_key FOREIGN KEY (sub_id) REFERENCES public.subcategories(subcategory_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3288 (class 2606 OID 24739)
-- Name: templates user_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.templates
    ADD CONSTRAINT user_key FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


--
-- TOC entry 3284 (class 2606 OID 24768)
-- Name: offers user_key; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.offers
    ADD CONSTRAINT user_key FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON UPDATE CASCADE ON DELETE CASCADE NOT VALID;


-- Completed on 2024-01-29 23:09:22 UTC

--
-- PostgreSQL database dump complete
--

