--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 17.1

-- Started on 2024-12-30 23:58:28

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 17375)
-- Name: pg_trgm; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pg_trgm WITH SCHEMA public;


--
-- TOC entry 4741 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION pg_trgm; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pg_trgm IS 'text similarity measurement and index searching based on trigrams';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 244 (class 1259 OID 18546)
-- Name: appointments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.appointments (
    id bigint NOT NULL,
    child_id bigint NOT NULL,
    doctor_id bigint,
    staff_id bigint NOT NULL,
    appointment_date date NOT NULL,
    start_time time(0) without time zone NOT NULL,
    end_time time(0) without time zone NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    appointment_title character varying
);


ALTER TABLE public.appointments OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 18545)
-- Name: appointments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.appointments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.appointments_id_seq OWNER TO postgres;

--
-- TOC entry 4742 (class 0 OID 0)
-- Dependencies: 243
-- Name: appointments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.appointments_id_seq OWNED BY public.appointments.id;


--
-- TOC entry 256 (class 1259 OID 18699)
-- Name: behaviour_assessment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.behaviour_assessment (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.behaviour_assessment OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 18698)
-- Name: behaviour_assessment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.behaviour_assessment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.behaviour_assessment_id_seq OWNER TO postgres;

--
-- TOC entry 4743 (class 0 OID 0)
-- Dependencies: 255
-- Name: behaviour_assessment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.behaviour_assessment_id_seq OWNED BY public.behaviour_assessment.id;


--
-- TOC entry 236 (class 1259 OID 18477)
-- Name: child_parent; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.child_parent (
    id bigint NOT NULL,
    parent_id bigint NOT NULL,
    child_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.child_parent OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 18476)
-- Name: child_parent_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.child_parent_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.child_parent_id_seq OWNER TO postgres;

--
-- TOC entry 4744 (class 0 OID 0)
-- Dependencies: 235
-- Name: child_parent_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.child_parent_id_seq OWNED BY public.child_parent.id;


--
-- TOC entry 234 (class 1259 OID 18457)
-- Name: children; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.children (
    id bigint NOT NULL,
    fullname json NOT NULL,
    dob date NOT NULL,
    birth_cert character varying(255) NOT NULL,
    gender_id bigint NOT NULL,
    registration_number character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.children OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 18456)
-- Name: children_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.children_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.children_id_seq OWNER TO postgres;

--
-- TOC entry 4745 (class 0 OID 0)
-- Dependencies: 233
-- Name: children_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.children_id_seq OWNED BY public.children.id;


--
-- TOC entry 260 (class 1259 OID 18751)
-- Name: cns; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cns (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.cns OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 18750)
-- Name: cns_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cns_id_seq OWNER TO postgres;

--
-- TOC entry 4746 (class 0 OID 0)
-- Dependencies: 259
-- Name: cns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cns_id_seq OWNED BY public.cns.id;


--
-- TOC entry 262 (class 1259 OID 18777)
-- Name: development_assessment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.development_assessment (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.development_assessment OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 18776)
-- Name: development_assessment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.development_assessment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.development_assessment_id_seq OWNER TO postgres;

--
-- TOC entry 4747 (class 0 OID 0)
-- Dependencies: 261
-- Name: development_assessment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.development_assessment_id_seq OWNED BY public.development_assessment.id;


--
-- TOC entry 254 (class 1259 OID 18673)
-- Name: development_milestones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.development_milestones (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.development_milestones OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 18672)
-- Name: development_milestones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.development_milestones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.development_milestones_id_seq OWNER TO postgres;

--
-- TOC entry 4748 (class 0 OID 0)
-- Dependencies: 253
-- Name: development_milestones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.development_milestones_id_seq OWNED BY public.development_milestones.id;


--
-- TOC entry 252 (class 1259 OID 18646)
-- Name: diagnosis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.diagnosis (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.diagnosis OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 18645)
-- Name: diagnosis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.diagnosis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.diagnosis_id_seq OWNER TO postgres;

--
-- TOC entry 4749 (class 0 OID 0)
-- Dependencies: 251
-- Name: diagnosis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.diagnosis_id_seq OWNED BY public.diagnosis.id;


--
-- TOC entry 238 (class 1259 OID 18496)
-- Name: doctor_specialization; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctor_specialization (
    id bigint NOT NULL,
    specialization character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.doctor_specialization OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 18495)
-- Name: doctor_specialization_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.doctor_specialization_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.doctor_specialization_id_seq OWNER TO postgres;

--
-- TOC entry 4750 (class 0 OID 0)
-- Dependencies: 237
-- Name: doctor_specialization_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.doctor_specialization_id_seq OWNED BY public.doctor_specialization.id;


--
-- TOC entry 266 (class 1259 OID 18812)
-- Name: examples; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.examples (
    id bigint NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.examples OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 18811)
-- Name: examples_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.examples_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.examples_id_seq OWNER TO postgres;

--
-- TOC entry 4751 (class 0 OID 0)
-- Dependencies: 265
-- Name: examples_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.examples_id_seq OWNED BY public.examples.id;


--
-- TOC entry 222 (class 1259 OID 18380)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 18379)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 4752 (class 0 OID 0)
-- Dependencies: 221
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 258 (class 1259 OID 18725)
-- Name: family_social_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.family_social_history (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.family_social_history OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 18724)
-- Name: family_social_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.family_social_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.family_social_history_id_seq OWNER TO postgres;

--
-- TOC entry 4753 (class 0 OID 0)
-- Dependencies: 257
-- Name: family_social_history_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.family_social_history_id_seq OWNED BY public.family_social_history.id;


--
-- TOC entry 226 (class 1259 OID 18406)
-- Name: gender; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gender (
    id bigint NOT NULL,
    gender character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.gender OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 18405)
-- Name: gender_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.gender_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.gender_id_seq OWNER TO postgres;

--
-- TOC entry 4754 (class 0 OID 0)
-- Dependencies: 225
-- Name: gender_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.gender_id_seq OWNED BY public.gender.id;


--
-- TOC entry 217 (class 1259 OID 18352)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 18351)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 4755 (class 0 OID 0)
-- Dependencies: 216
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 232 (class 1259 OID 18434)
-- Name: parents; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parents (
    id bigint NOT NULL,
    fullname json NOT NULL,
    dob date,
    gender_id bigint NOT NULL,
    telephone character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    national_id character varying(255) NOT NULL,
    employer character varying(255),
    insurance character varying(255),
    referer character varying(255),
    relationship_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.parents OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 18433)
-- Name: parents_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.parents_id_seq OWNER TO postgres;

--
-- TOC entry 4756 (class 0 OID 0)
-- Dependencies: 231
-- Name: parents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.parents_id_seq OWNED BY public.parents.id;


--
-- TOC entry 220 (class 1259 OID 18372)
-- Name: password_resets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 18844)
-- Name: past_medical_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.past_medical_history (
    id bigint NOT NULL,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.past_medical_history OWNER TO postgres;

--
-- TOC entry 269 (class 1259 OID 18843)
-- Name: past_medical_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.past_medical_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.past_medical_history_id_seq OWNER TO postgres;

--
-- TOC entry 4757 (class 0 OID 0)
-- Dependencies: 269
-- Name: past_medical_history_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.past_medical_history_id_seq OWNED BY public.past_medical_history.id;


--
-- TOC entry 264 (class 1259 OID 18803)
-- Name: payment_modes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payment_modes (
    id bigint NOT NULL,
    payment_mode character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.payment_modes OWNER TO postgres;

--
-- TOC entry 263 (class 1259 OID 18802)
-- Name: payment_modes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payment_modes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payment_modes_id_seq OWNER TO postgres;

--
-- TOC entry 4758 (class 0 OID 0)
-- Dependencies: 263
-- Name: payment_modes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payment_modes_id_seq OWNED BY public.payment_modes.id;


--
-- TOC entry 272 (class 1259 OID 18865)
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint,
    staff_id bigint,
    payment_mode_id bigint,
    amount numeric(10,2) NOT NULL,
    payment_date date NOT NULL,
    invoice_numnber character varying(255) NOT NULL,
    receipt_number character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- TOC entry 271 (class 1259 OID 18864)
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payments_id_seq OWNER TO postgres;

--
-- TOC entry 4759 (class 0 OID 0)
-- Dependencies: 271
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- TOC entry 268 (class 1259 OID 18823)
-- Name: perinatal_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.perinatal_history (
    id bigint NOT NULL,
    child_id bigint NOT NULL,
    doctor_id bigint,
    data json NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.perinatal_history OWNER TO postgres;

--
-- TOC entry 267 (class 1259 OID 18822)
-- Name: perinatal_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.perinatal_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.perinatal_history_id_seq OWNER TO postgres;

--
-- TOC entry 4760 (class 0 OID 0)
-- Dependencies: 267
-- Name: perinatal_history_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.perinatal_history_id_seq OWNED BY public.perinatal_history.id;


--
-- TOC entry 224 (class 1259 OID 18392)
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 18391)
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 4761 (class 0 OID 0)
-- Dependencies: 223
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- TOC entry 230 (class 1259 OID 18424)
-- Name: relationships; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.relationships (
    id bigint NOT NULL,
    relationship character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.relationships OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 18423)
-- Name: relationships_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.relationships_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.relationships_id_seq OWNER TO postgres;

--
-- TOC entry 4762 (class 0 OID 0)
-- Dependencies: 229
-- Name: relationships_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.relationships_id_seq OWNED BY public.relationships.id;


--
-- TOC entry 228 (class 1259 OID 18415)
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    role character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 18414)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- TOC entry 4763 (class 0 OID 0)
-- Dependencies: 227
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 242 (class 1259 OID 18514)
-- Name: staff; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.staff (
    id bigint NOT NULL,
    fullname json NOT NULL,
    telephone character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    staff_no character varying(255) NOT NULL,
    remember_token character varying(100),
    gender_id bigint NOT NULL,
    role_id bigint NOT NULL,
    specialization_id bigint,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.staff OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 18513)
-- Name: staff_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.staff_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.staff_id_seq OWNER TO postgres;

--
-- TOC entry 4764 (class 0 OID 0)
-- Dependencies: 241
-- Name: staff_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.staff_id_seq OWNED BY public.staff.id;


--
-- TOC entry 250 (class 1259 OID 18615)
-- Name: triage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.triage (
    id bigint NOT NULL,
    visit_id bigint,
    child_id bigint NOT NULL,
    staff_id bigint,
    data json NOT NULL,
    assessment_id bigint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.triage OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 18606)
-- Name: triage_assessment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.triage_assessment (
    id bigint NOT NULL,
    assessment character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.triage_assessment OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 18605)
-- Name: triage_assessment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.triage_assessment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.triage_assessment_id_seq OWNER TO postgres;

--
-- TOC entry 4765 (class 0 OID 0)
-- Dependencies: 247
-- Name: triage_assessment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.triage_assessment_id_seq OWNED BY public.triage_assessment.id;


--
-- TOC entry 249 (class 1259 OID 18614)
-- Name: triage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.triage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.triage_id_seq OWNER TO postgres;

--
-- TOC entry 4766 (class 0 OID 0)
-- Dependencies: 249
-- Name: triage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.triage_id_seq OWNED BY public.triage.id;


--
-- TOC entry 219 (class 1259 OID 18359)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 18358)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 4767 (class 0 OID 0)
-- Dependencies: 218
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 240 (class 1259 OID 18505)
-- Name: visit_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.visit_type (
    id bigint NOT NULL,
    visit_type character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.visit_type OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 18504)
-- Name: visit_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.visit_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.visit_type_id_seq OWNER TO postgres;

--
-- TOC entry 4768 (class 0 OID 0)
-- Dependencies: 239
-- Name: visit_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.visit_type_id_seq OWNED BY public.visit_type.id;


--
-- TOC entry 246 (class 1259 OID 18570)
-- Name: visits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.visits (
    id bigint NOT NULL,
    visit_date date NOT NULL,
    source_type character varying(255) NOT NULL,
    source_contact character varying(255) NOT NULL,
    visit_type bigint NOT NULL,
    child_id bigint NOT NULL,
    staff_id bigint NOT NULL,
    doctor_id bigint NOT NULL,
    appointment_id bigint,
    created_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.visits OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 18569)
-- Name: visits_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.visits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.visits_id_seq OWNER TO postgres;

--
-- TOC entry 4769 (class 0 OID 0)
-- Dependencies: 245
-- Name: visits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.visits_id_seq OWNED BY public.visits.id;


--
-- TOC entry 4364 (class 2604 OID 18549)
-- Name: appointments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments ALTER COLUMN id SET DEFAULT nextval('public.appointments_id_seq'::regclass);


--
-- TOC entry 4382 (class 2604 OID 18702)
-- Name: behaviour_assessment id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.behaviour_assessment ALTER COLUMN id SET DEFAULT nextval('public.behaviour_assessment_id_seq'::regclass);


--
-- TOC entry 4352 (class 2604 OID 18480)
-- Name: child_parent id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.child_parent ALTER COLUMN id SET DEFAULT nextval('public.child_parent_id_seq'::regclass);


--
-- TOC entry 4349 (class 2604 OID 18460)
-- Name: children id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.children ALTER COLUMN id SET DEFAULT nextval('public.children_id_seq'::regclass);


--
-- TOC entry 4388 (class 2604 OID 18754)
-- Name: cns id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cns ALTER COLUMN id SET DEFAULT nextval('public.cns_id_seq'::regclass);


--
-- TOC entry 4391 (class 2604 OID 18780)
-- Name: development_assessment id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_assessment ALTER COLUMN id SET DEFAULT nextval('public.development_assessment_id_seq'::regclass);


--
-- TOC entry 4379 (class 2604 OID 18676)
-- Name: development_milestones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_milestones ALTER COLUMN id SET DEFAULT nextval('public.development_milestones_id_seq'::regclass);


--
-- TOC entry 4376 (class 2604 OID 18649)
-- Name: diagnosis id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diagnosis ALTER COLUMN id SET DEFAULT nextval('public.diagnosis_id_seq'::regclass);


--
-- TOC entry 4355 (class 2604 OID 18499)
-- Name: doctor_specialization id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_specialization ALTER COLUMN id SET DEFAULT nextval('public.doctor_specialization_id_seq'::regclass);


--
-- TOC entry 4397 (class 2604 OID 18815)
-- Name: examples id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examples ALTER COLUMN id SET DEFAULT nextval('public.examples_id_seq'::regclass);


--
-- TOC entry 4332 (class 2604 OID 18383)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4385 (class 2604 OID 18728)
-- Name: family_social_history id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.family_social_history ALTER COLUMN id SET DEFAULT nextval('public.family_social_history_id_seq'::regclass);


--
-- TOC entry 4337 (class 2604 OID 18409)
-- Name: gender id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gender ALTER COLUMN id SET DEFAULT nextval('public.gender_id_seq'::regclass);


--
-- TOC entry 4328 (class 2604 OID 18355)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4346 (class 2604 OID 18437)
-- Name: parents id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parents ALTER COLUMN id SET DEFAULT nextval('public.parents_id_seq'::regclass);


--
-- TOC entry 4403 (class 2604 OID 18847)
-- Name: past_medical_history id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.past_medical_history ALTER COLUMN id SET DEFAULT nextval('public.past_medical_history_id_seq'::regclass);


--
-- TOC entry 4394 (class 2604 OID 18806)
-- Name: payment_modes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_modes ALTER COLUMN id SET DEFAULT nextval('public.payment_modes_id_seq'::regclass);


--
-- TOC entry 4406 (class 2604 OID 18868)
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- TOC entry 4400 (class 2604 OID 18826)
-- Name: perinatal_history id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.perinatal_history ALTER COLUMN id SET DEFAULT nextval('public.perinatal_history_id_seq'::regclass);


--
-- TOC entry 4334 (class 2604 OID 18395)
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- TOC entry 4343 (class 2604 OID 18427)
-- Name: relationships id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.relationships ALTER COLUMN id SET DEFAULT nextval('public.relationships_id_seq'::regclass);


--
-- TOC entry 4340 (class 2604 OID 18418)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 4361 (class 2604 OID 18517)
-- Name: staff id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff ALTER COLUMN id SET DEFAULT nextval('public.staff_id_seq'::regclass);


--
-- TOC entry 4373 (class 2604 OID 18618)
-- Name: triage id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage ALTER COLUMN id SET DEFAULT nextval('public.triage_id_seq'::regclass);


--
-- TOC entry 4370 (class 2604 OID 18609)
-- Name: triage_assessment id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage_assessment ALTER COLUMN id SET DEFAULT nextval('public.triage_assessment_id_seq'::regclass);


--
-- TOC entry 4329 (class 2604 OID 18362)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 4358 (class 2604 OID 18508)
-- Name: visit_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visit_type ALTER COLUMN id SET DEFAULT nextval('public.visit_type_id_seq'::regclass);


--
-- TOC entry 4367 (class 2604 OID 18573)
-- Name: visits id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits ALTER COLUMN id SET DEFAULT nextval('public.visits_id_seq'::regclass);


--
-- TOC entry 4707 (class 0 OID 18546)
-- Dependencies: 244
-- Data for Name: appointments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.appointments (id, child_id, doctor_id, staff_id, appointment_date, start_time, end_time, status, created_at, updated_at, appointment_title) FROM stdin;
1	1	2	3	2025-01-04	10:00:00	11:00:00	pending	2024-12-30 16:22:53	2024-12-30 16:22:53	\N
2	2	2	3	2024-01-04	11:00:00	12:00:00	pending	2024-12-30 16:22:53	2024-12-30 16:22:53	\N
\.


--
-- TOC entry 4719 (class 0 OID 18699)
-- Dependencies: 256
-- Data for Name: behaviour_assessment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.behaviour_assessment (id, visit_id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	1	2	{"HyperActivity":"Moderate hyperactivity observed in play","Attention":"Short attention span but improves with engagement","SocialInteractions":"Interacts well with peers but needs encouragement","MoodAnxiety":"Generally happy but occasional signs of anxiety in new situations","PlayInterests":"Prefers building blocks and outdoor games","Communication":"Speaks in short sentences; improving vocabulary","RRB":"Shows repetitive hand movements when excited","SensoryProcessing":"Sensitive to loud noises and bright lights","Sleep":"Sleeps well but occasional difficulty settling at bedtime","Adaptive":"Independent in dressing but needs help with shoe tying"}	2024-12-30 16:27:27	2024-12-30 16:27:27
2	2	2	2	{"HyperActivity":"Low hyperactivity; calm during structured tasks","Attention":"Good focus on tasks of interest; easily distracted otherwise","SocialInteractions":"Enjoys group activities but hesitant to initiate interaction","MoodAnxiety":"Appears content; no visible signs of anxiety","PlayInterests":"Likes puzzles and drawing; enjoys role-play games","Communication":"Uses full sentences; clear speech with occasional pauses","RRB":"Tends to arrange toys in patterns during play","SensoryProcessing":"Avoids sticky textures but tolerates most other sensory inputs","Sleep":"Regular sleep patterns with no known disturbances","Adaptive":"Manages daily routines well; independent in most activities"}	2024-12-30 16:27:27	2024-12-30 16:27:27
\.


--
-- TOC entry 4699 (class 0 OID 18477)
-- Dependencies: 236
-- Data for Name: child_parent; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.child_parent (id, parent_id, child_id, created_at, updated_at) FROM stdin;
1	1	1	2024-12-30 16:17:46	2024-12-30 16:17:46
2	2	2	2024-12-30 16:17:46	2024-12-30 16:17:46
\.


--
-- TOC entry 4697 (class 0 OID 18457)
-- Dependencies: 234
-- Data for Name: children; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.children (id, fullname, dob, birth_cert, gender_id, registration_number, created_at, updated_at) FROM stdin;
1	{"first_name":"John","middle_name":"Doe","last_name":"Smith"}	2018-05-10	BC/123456	1	REG-001	2024-12-30 16:17:45	2024-12-30 16:17:45
2	{"first_name":"Alice","middle_name":"Wilson","last_name":"Johnson"}	2020-01-22	BC/789012	2	REG-002	2024-12-30 16:17:45	2024-12-30 16:17:45
\.


--
-- TOC entry 4723 (class 0 OID 18751)
-- Dependencies: 260
-- Data for Name: cns; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cns (id, visit_id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	1	2	{"avpu":"A","vision":"Normal; no issues reported","hearing":"Normal; responds well to sound","cranialNerves":"All functions within normal limits","ambulation":"Yes; walks independently with steady gait","cardiovascular":"Normal heart rate and rhythm; no murmurs detected","respiratory":"Clear breath sounds; no wheezing or stridor","musculoskeletal":"Full range of motion; no pain or swelling observed"}	2024-12-30 16:27:28	2024-12-30 16:27:28
2	2	2	2	{"avpu":"V","vision":"Mild myopia; corrected with glasses","hearing":"Moderate hearing loss in left ear; requires further evaluation","cranialNerves":"Cranial nerve VII (facial) shows slight weakness","ambulation":"Yes; slight limp observed on the right leg","cardiovascular":"Elevated heart rate; follow-up recommended","respiratory":"Mild wheezing on exertion; asthma suspected","musculoskeletal":"Minor joint stiffness in the morning; improves with movement"}	2024-12-30 16:27:28	2024-12-30 16:27:28
\.


--
-- TOC entry 4725 (class 0 OID 18777)
-- Dependencies: 262
-- Data for Name: development_assessment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.development_assessment (id, visit_id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	1	2	{"grossMotor":"Able to walk independently; runs with balance","fineMotor":"Can hold a pencil and draw simple shapes","speech":"Speaks in short sentences; vocabulary improving","selfCare":"Can dress with minimal assistance; feeds independently","cognitive":"Recognizes shapes, colors, and basic numbers","grossDevAge":"4","fineDevAge":"3.5","speechDevAge":"4","selfDevAge":"4","cognitiveDevAge":"4.5"}	2024-12-30 16:27:28	2024-12-30 16:27:28
2	2	2	2	{"grossMotor":"Walks with support; difficulty running or jumping","fineMotor":"Can stack blocks but struggles with precise tasks","speech":"Limited vocabulary; uses gestures to communicate","selfCare":"Needs help with dressing and feeding","cognitive":"Understands simple instructions; enjoys solving puzzles","grossDevAge":"2.5","fineDevAge":"2","speechDevAge":"2.5","selfDevAge":"2","cognitiveDevAge":"3"}	2024-12-30 16:27:28	2024-12-30 16:27:28
\.


--
-- TOC entry 4717 (class 0 OID 18673)
-- Dependencies: 254
-- Data for Name: development_milestones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.development_milestones (id, visit_id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	1	2	{"Neck Support":"3","Sitting":"6","Crawling":"8","Standing":"10","Walking":"12","Cooing\\/Babbling":"4","First Word":"10","Vocabulary":"15","Phrase Speech":"20","Conversational":"24","Smiling\\/Laughing":"2","Attachments":"6","Feeding":"12","Elimination":"18","Teething":"6"}	2024-12-30 16:27:26	2024-12-30 16:27:26
2	2	2	2	{"Neck Support":"4","Sitting":"7","Crawling":"9","Standing":"11","Walking":"14","Cooing\\/Babbling":"5","First Word":"11","Vocabulary":"18","Phrase Speech":"22","Conversational":"30","Smiling\\/Laughing":"3","Attachments":"5","Feeding":"10","Elimination":"20","Teething":"7"}	2024-12-30 16:27:26	2024-12-30 16:27:26
\.


--
-- TOC entry 4715 (class 0 OID 18646)
-- Dependencies: 252
-- Data for Name: diagnosis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.diagnosis (id, visit_id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4701 (class 0 OID 18496)
-- Dependencies: 238
-- Data for Name: doctor_specialization; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctor_specialization (id, specialization, created_at, updated_at) FROM stdin;
1	Pediatrician	2024-12-30 16:17:43	2024-12-30 16:17:43
2	Occupational Therapy	2024-12-30 16:17:43	2024-12-30 16:17:43
3	Speech Therapy	2024-12-30 16:17:43	2024-12-30 16:17:43
4	Physiotherapy	2024-12-30 16:17:43	2024-12-30 16:17:43
5	Nutrition	2024-12-30 16:17:43	2024-12-30 16:17:43
6	ABA	2024-12-30 16:17:43	2024-12-30 16:17:43
7	Other	2024-12-30 16:17:43	2024-12-30 16:17:43
\.


--
-- TOC entry 4729 (class 0 OID 18812)
-- Dependencies: 266
-- Data for Name: examples; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.examples (id, email, password, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4685 (class 0 OID 18380)
-- Dependencies: 222
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- TOC entry 4721 (class 0 OID 18725)
-- Dependencies: 258
-- Data for Name: family_social_history; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.family_social_history (id, visit_id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	1	2	{"FamilyComposition":"Mother, Father, 2 siblings\\nClose-knit family\\nLives in an urban area","FamilyHealthSocial":"No history of genetic disorders\\nOccasional illnesses like colds\\nSupportive extended family","Schooling":"Attends local elementary school\\nGrade 3\\nEnjoys learning and participates in extracurricular activities"}	2024-12-30 16:27:27	2024-12-30 16:27:27
2	1	1	2	{"FamilyComposition":"Single parent (mother)\\n2 children\\nSupport from grandparents","FamilyHealthSocial":"Asthma runs in the family\\nFrequent visits to the clinic for check-ups\\nModerate social connections","Schooling":"Homeschooling due to health reasons\\nLearning at grade 2 level\\nLoves arts and crafts"}	2024-12-30 16:27:27	2024-12-30 16:27:27
\.


--
-- TOC entry 4689 (class 0 OID 18406)
-- Dependencies: 226
-- Data for Name: gender; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.gender (id, gender, created_at, updated_at) FROM stdin;
1	Male	2024-12-30 16:17:41	2024-12-30 16:17:41
2	Female	2024-12-30 16:17:41	2024-12-30 16:17:41
3	Prefer not to say	2024-12-30 16:17:41	2024-12-30 16:17:41
\.


--
-- TOC entry 4680 (class 0 OID 18352)
-- Dependencies: 217
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2014_10_12_000000_create_users_table	1
2	2014_10_12_100000_create_password_resets_table	1
3	2019_08_19_000000_create_failed_jobs_table	1
4	2019_12_14_000001_create_personal_access_tokens_table	1
5	2024_12_23_112607_create_gender	1
6	2024_12_23_112947_create_roles	1
7	2024_12_23_113141_relationships	1
8	2024_12_23_113437_create_parents	1
9	2024_12_23_114416_create_children	1
10	2024_12_23_114417_create_child_parent	1
11	2024_12_23_115303_create_doctor_specialization	1
12	2024_12_23_120035_create_visit_type	1
13	2024_12_23_120102_create_staff	1
14	2024_12_23_121324_create_appointments	1
15	2024_12_23_121325_create_visits	1
16	2024_12_23_121717_create_triage_assessment	1
17	2024_12_23_121718_create_triage	1
18	2024_12_23_121839_create_diagnosis	1
19	2024_12_23_121935_create_development_milestones	1
20	2024_12_23_122027_create_behaviour_assessment	1
21	2024_12_23_122303_create_family_social_history	1
22	2024_12_23_122416_create_cns	1
23	2024_12_23_122441_create_development_assessment	1
24	2024_12_23_122508_create_payment_modes	1
25	2024_12_23_162232_create_examples	1
26	2024_12_28_052513_perinatal_history_table	1
27	2024_12_28_052803_past_medical_history_table	1
28	2024_12_30_065339_create_payments	1
\.


--
-- TOC entry 4695 (class 0 OID 18434)
-- Dependencies: 232
-- Data for Name: parents; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.parents (id, fullname, dob, gender_id, telephone, email, national_id, employer, insurance, referer, relationship_id, created_at, updated_at) FROM stdin;
2	{"first_name":"David","middle_name":"Lee","last_name":"Johnson"}	1978-11-20	1	9876543210	david.johnson@example.com	98765432	Tech Solutions	Life Insurance Inc	\N	2	2024-12-30 16:17:45	2024-12-30 16:17:45
1	{"first_name": "Jane", "middle_name": "Martha", "last_name": "Smith"}	1980-03-15	2	1234567890	jane.smith@example.com	12345678	Acme Corp	Health Insurance Co	Dr. Referer	1	2024-12-30 16:17:45	2024-12-30 16:17:45
\.


--
-- TOC entry 4683 (class 0 OID 18372)
-- Dependencies: 220
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- TOC entry 4733 (class 0 OID 18844)
-- Dependencies: 270
-- Data for Name: past_medical_history; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.past_medical_history (id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	2	{"illnesses":"Frequent colds and flu,Diagnosed with mild asthma,Occasional stomach upsets","investigations":"Blood tests for allergies,Chest X-ray for asthma diagnosis,Routine pediatric check-ups","interventions":"Inhaler prescribed for asthma,Dietary adjustments for food intolerance,Physiotherapy sessions for improved lung capacity"}	2024-12-30 16:27:29	2024-12-30 16:27:29
2	2	2	{"illnesses":"Chickenpox at age 4,Recurring ear infections,Seasonal allergies","investigations":"Hearing test after multiple ear infections,Skin prick test for allergy triggers,Comprehensive health screening","interventions":"Antibiotics for ear infections,Antihistamines for allergies,Vaccinations updated regularly"}	2024-12-30 16:27:29	2024-12-30 16:27:29
\.


--
-- TOC entry 4727 (class 0 OID 18803)
-- Dependencies: 264
-- Data for Name: payment_modes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payment_modes (id, payment_mode, created_at, updated_at) FROM stdin;
1	MPESA	2024-12-30 16:17:44	2024-12-30 16:17:44
2	CASH	2024-12-30 16:17:44	2024-12-30 16:17:44
3	BANK	2024-12-30 16:17:44	2024-12-30 16:17:44
4	Other	2024-12-30 16:17:44	2024-12-30 16:17:44
\.


--
-- TOC entry 4735 (class 0 OID 18865)
-- Dependencies: 272
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, visit_id, child_id, staff_id, payment_mode_id, amount, payment_date, invoice_numnber, receipt_number, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4731 (class 0 OID 18823)
-- Dependencies: 268
-- Data for Name: perinatal_history; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.perinatal_history (id, child_id, doctor_id, data, created_at, updated_at) FROM stdin;
1	1	2	{"preConception":"Planned pregnancy with prenatal vitamins","antenatalHistory":"Routine antenatal visits with no complications","parity":"1","gestation":"Full term (40 weeks)","labour":"Normal progression, 8 hours","delivery":"Vaginal delivery","agarScore":"9 at 1 minute, 10 at 5 minutes","bwt":"3.5 kg","bFeeding":"Initiated within the first hour","hypoglaecemia":"No signs","siezures":"None","juandice":"Mild, resolved without treatment","rds":"None","sepsis":"Negative blood cultures"}	2024-12-30 16:27:29	2024-12-30 16:27:29
2	2	2	{"preConception":"Unplanned but healthy pregnancy","antenatalHistory":"Gestational diabetes managed with diet","parity":"2","gestation":"Preterm (35 weeks)","labour":"Induced due to complications","delivery":"Cesarean section","agarScore":"7 at 1 minute, 8 at 5 minutes","bwt":"2.8 kg","bFeeding":"Delayed due to NICU stay","hypoglaecemia":"Monitored, resolved within 24 hours","siezures":"None observed","juandice":"Phototherapy required","rds":"Moderate, treated with CPAP","sepsis":"Prophylactic antibiotics given"}	2024-12-30 16:27:29	2024-12-30 16:27:29
\.


--
-- TOC entry 4687 (class 0 OID 18392)
-- Dependencies: 224
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4693 (class 0 OID 18424)
-- Dependencies: 230
-- Data for Name: relationships; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.relationships (id, relationship, created_at, updated_at) FROM stdin;
1	Mother	2024-12-30 16:17:42	2024-12-30 16:17:42
2	Father	2024-12-30 16:17:42	2024-12-30 16:17:42
3	Guardian	2024-12-30 16:17:42	2024-12-30 16:17:42
\.


--
-- TOC entry 4691 (class 0 OID 18415)
-- Dependencies: 228
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, role, created_at, updated_at) FROM stdin;
1	Nurse	2024-12-30 16:17:42	2024-12-30 16:17:42
2	Doctor	2024-12-30 16:17:42	2024-12-30 16:17:42
3	Receptionist	2024-12-30 16:17:42	2024-12-30 16:17:42
4	Admin	2024-12-30 16:17:42	2024-12-30 16:17:42
\.


--
-- TOC entry 4705 (class 0 OID 18514)
-- Dependencies: 242
-- Data for Name: staff; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.staff (id, fullname, telephone, email, email_verified_at, password, staff_no, remember_token, gender_id, role_id, specialization_id, created_at, updated_at) FROM stdin;
1	{"first_name":"Nurse"}	000000000	nurse@gmail.com	\N	$2y$10$2tVjvrTKZ3c6iL7MSuvMlePRZy265Nk/6cen1siZRM0IxncWLLKeG	1	\N	1	1	\N	2024-12-30 16:17:47	2024-12-30 16:17:47
2	{"first_name":"Doctor"}	1111111111	doctor@gmail.com	\N	$2y$10$z/ajy7snIAGIPSWyl2w2HOmUbkCWzH0B7t7Xy4kx1YFYo.MU2bYIi	2	\N	1	2	1	2024-12-30 16:17:47	2024-12-30 16:17:47
3	{"first_name":"Receptionist"}	2222222222	receptionist@gmail.com	\N	$2y$10$pJFxYPFc5bbbWqwSSWwTheewYFDcqiDQjWYHw3UwwMWxSdgTEmckq	3	\N	2	3	\N	2024-12-30 16:17:47	2024-12-30 16:17:47
4	{"first_name":"Admin"}	3333333333	admin@gmail.com	\N	$2y$10$sGv4vnsQv6DEmbNDFI/Fhedx1PyJyl5n6M.uGO3kXbubJuXu78Uc2	4	\N	1	4	\N	2024-12-30 16:17:47	2024-12-30 16:17:47
\.


--
-- TOC entry 4713 (class 0 OID 18615)
-- Dependencies: 250
-- Data for Name: triage; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.triage (id, visit_id, child_id, staff_id, data, assessment_id, created_at, updated_at) FROM stdin;
1	1	1	1	{"temperature":37.5,"weight":12.5,"height":0.75,"head_circumference":0.45,"blood_pressure":"120\\/80","pulse_rate":80,"respiratory_rate":20,"oxygen_saturation":98,"MUAC":11.5}	3	2024-12-30 16:22:54	2024-12-30 16:22:54
2	2	2	1	{"temperature":38,"weight":10.5,"height":0.65,"HC":0.4,"blood_pressure":"110\\/70","pulse_rate":90,"respiratory_rate":25,"oxygen_saturation":95,"MUAC":12.5}	2	2024-12-30 16:22:54	2024-12-30 16:22:54
\.


--
-- TOC entry 4711 (class 0 OID 18606)
-- Dependencies: 248
-- Data for Name: triage_assessment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.triage_assessment (id, assessment, created_at, updated_at) FROM stdin;
1	Emergency	2024-12-30 16:17:44	2024-12-30 16:17:44
2	Priority	2024-12-30 16:17:44	2024-12-30 16:17:44
3	Routine	2024-12-30 16:17:44	2024-12-30 16:17:44
4	Other	2024-12-30 16:17:44	2024-12-30 16:17:44
\.


--
-- TOC entry 4682 (class 0 OID 18359)
-- Dependencies: 219
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4703 (class 0 OID 18505)
-- Dependencies: 240
-- Data for Name: visit_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.visit_type (id, visit_type, created_at, updated_at) FROM stdin;
1	Consultation	2024-12-30 16:17:43	2024-12-30 16:17:43
2	Follow-Up	2024-12-30 16:17:43	2024-12-30 16:17:43
3	Emergency	2024-12-30 16:17:43	2024-12-30 16:17:43
4	Walk-In	2024-12-30 16:17:43	2024-12-30 16:17:43
5	Other	2024-12-30 16:17:43	2024-12-30 16:17:43
\.


--
-- TOC entry 4709 (class 0 OID 18570)
-- Dependencies: 246
-- Data for Name: visits; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.visits (id, visit_date, source_type, source_contact, visit_type, child_id, staff_id, doctor_id, appointment_id, created_at, updated_at) FROM stdin;
1	2024-05-10	MySource	1234567890	1	1	3	2	1	2024-12-30 16:22:53	2024-12-30 16:22:53
2	2024-05-12	MySource	9876543210	2	2	3	2	2	2024-12-30 16:22:53	2024-12-30 16:22:53
\.


--
-- TOC entry 4770 (class 0 OID 0)
-- Dependencies: 243
-- Name: appointments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.appointments_id_seq', 2, true);


--
-- TOC entry 4771 (class 0 OID 0)
-- Dependencies: 255
-- Name: behaviour_assessment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.behaviour_assessment_id_seq', 2, true);


--
-- TOC entry 4772 (class 0 OID 0)
-- Dependencies: 235
-- Name: child_parent_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.child_parent_id_seq', 2, true);


--
-- TOC entry 4773 (class 0 OID 0)
-- Dependencies: 233
-- Name: children_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.children_id_seq', 2, true);


--
-- TOC entry 4774 (class 0 OID 0)
-- Dependencies: 259
-- Name: cns_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cns_id_seq', 2, true);


--
-- TOC entry 4775 (class 0 OID 0)
-- Dependencies: 261
-- Name: development_assessment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.development_assessment_id_seq', 2, true);


--
-- TOC entry 4776 (class 0 OID 0)
-- Dependencies: 253
-- Name: development_milestones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.development_milestones_id_seq', 2, true);


--
-- TOC entry 4777 (class 0 OID 0)
-- Dependencies: 251
-- Name: diagnosis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.diagnosis_id_seq', 1, false);


--
-- TOC entry 4778 (class 0 OID 0)
-- Dependencies: 237
-- Name: doctor_specialization_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.doctor_specialization_id_seq', 7, true);


--
-- TOC entry 4779 (class 0 OID 0)
-- Dependencies: 265
-- Name: examples_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.examples_id_seq', 1, false);


--
-- TOC entry 4780 (class 0 OID 0)
-- Dependencies: 221
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 4781 (class 0 OID 0)
-- Dependencies: 257
-- Name: family_social_history_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.family_social_history_id_seq', 2, true);


--
-- TOC entry 4782 (class 0 OID 0)
-- Dependencies: 225
-- Name: gender_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.gender_id_seq', 3, true);


--
-- TOC entry 4783 (class 0 OID 0)
-- Dependencies: 216
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 28, true);


--
-- TOC entry 4784 (class 0 OID 0)
-- Dependencies: 231
-- Name: parents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.parents_id_seq', 2, true);


--
-- TOC entry 4785 (class 0 OID 0)
-- Dependencies: 269
-- Name: past_medical_history_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.past_medical_history_id_seq', 2, true);


--
-- TOC entry 4786 (class 0 OID 0)
-- Dependencies: 263
-- Name: payment_modes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payment_modes_id_seq', 4, true);


--
-- TOC entry 4787 (class 0 OID 0)
-- Dependencies: 271
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 1, false);


--
-- TOC entry 4788 (class 0 OID 0)
-- Dependencies: 267
-- Name: perinatal_history_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.perinatal_history_id_seq', 2, true);


--
-- TOC entry 4789 (class 0 OID 0)
-- Dependencies: 223
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- TOC entry 4790 (class 0 OID 0)
-- Dependencies: 229
-- Name: relationships_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.relationships_id_seq', 3, true);


--
-- TOC entry 4791 (class 0 OID 0)
-- Dependencies: 227
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 4, true);


--
-- TOC entry 4792 (class 0 OID 0)
-- Dependencies: 241
-- Name: staff_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.staff_id_seq', 4, true);


--
-- TOC entry 4793 (class 0 OID 0)
-- Dependencies: 247
-- Name: triage_assessment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.triage_assessment_id_seq', 4, true);


--
-- TOC entry 4794 (class 0 OID 0)
-- Dependencies: 249
-- Name: triage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.triage_id_seq', 2, true);


--
-- TOC entry 4795 (class 0 OID 0)
-- Dependencies: 218
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- TOC entry 4796 (class 0 OID 0)
-- Dependencies: 239
-- Name: visit_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.visit_type_id_seq', 5, true);


--
-- TOC entry 4797 (class 0 OID 0)
-- Dependencies: 245
-- Name: visits_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.visits_id_seq', 2, true);


--
-- TOC entry 4457 (class 2606 OID 18553)
-- Name: appointments appointments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_pkey PRIMARY KEY (id);


--
-- TOC entry 4469 (class 2606 OID 18708)
-- Name: behaviour_assessment behaviour_assessment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.behaviour_assessment
    ADD CONSTRAINT behaviour_assessment_pkey PRIMARY KEY (id);


--
-- TOC entry 4443 (class 2606 OID 18484)
-- Name: child_parent child_parent_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.child_parent
    ADD CONSTRAINT child_parent_pkey PRIMARY KEY (id);


--
-- TOC entry 4437 (class 2606 OID 18473)
-- Name: children children_birth_cert_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.children
    ADD CONSTRAINT children_birth_cert_unique UNIQUE (birth_cert);


--
-- TOC entry 4439 (class 2606 OID 18466)
-- Name: children children_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.children
    ADD CONSTRAINT children_pkey PRIMARY KEY (id);


--
-- TOC entry 4441 (class 2606 OID 18475)
-- Name: children children_registration_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.children
    ADD CONSTRAINT children_registration_number_unique UNIQUE (registration_number);


--
-- TOC entry 4473 (class 2606 OID 18760)
-- Name: cns cns_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cns
    ADD CONSTRAINT cns_pkey PRIMARY KEY (id);


--
-- TOC entry 4475 (class 2606 OID 18786)
-- Name: development_assessment development_assessment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_assessment
    ADD CONSTRAINT development_assessment_pkey PRIMARY KEY (id);


--
-- TOC entry 4467 (class 2606 OID 18682)
-- Name: development_milestones development_milestones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_milestones
    ADD CONSTRAINT development_milestones_pkey PRIMARY KEY (id);


--
-- TOC entry 4465 (class 2606 OID 18655)
-- Name: diagnosis diagnosis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diagnosis
    ADD CONSTRAINT diagnosis_pkey PRIMARY KEY (id);


--
-- TOC entry 4445 (class 2606 OID 18503)
-- Name: doctor_specialization doctor_specialization_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctor_specialization
    ADD CONSTRAINT doctor_specialization_pkey PRIMARY KEY (id);


--
-- TOC entry 4479 (class 2606 OID 18821)
-- Name: examples examples_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.examples
    ADD CONSTRAINT examples_pkey PRIMARY KEY (id);


--
-- TOC entry 4418 (class 2606 OID 18388)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 4420 (class 2606 OID 18390)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 4471 (class 2606 OID 18734)
-- Name: family_social_history family_social_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.family_social_history
    ADD CONSTRAINT family_social_history_pkey PRIMARY KEY (id);


--
-- TOC entry 4427 (class 2606 OID 18413)
-- Name: gender gender_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gender
    ADD CONSTRAINT gender_pkey PRIMARY KEY (id);


--
-- TOC entry 4410 (class 2606 OID 18357)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4433 (class 2606 OID 18455)
-- Name: parents parents_national_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parents
    ADD CONSTRAINT parents_national_id_unique UNIQUE (national_id);


--
-- TOC entry 4435 (class 2606 OID 18443)
-- Name: parents parents_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parents
    ADD CONSTRAINT parents_pkey PRIMARY KEY (id);


--
-- TOC entry 4416 (class 2606 OID 18378)
-- Name: password_resets password_resets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_resets
    ADD CONSTRAINT password_resets_pkey PRIMARY KEY (email);


--
-- TOC entry 4483 (class 2606 OID 18853)
-- Name: past_medical_history past_medical_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.past_medical_history
    ADD CONSTRAINT past_medical_history_pkey PRIMARY KEY (id);


--
-- TOC entry 4477 (class 2606 OID 18810)
-- Name: payment_modes payment_modes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_modes
    ADD CONSTRAINT payment_modes_pkey PRIMARY KEY (id);


--
-- TOC entry 4485 (class 2606 OID 18897)
-- Name: payments payments_invoice_numnber_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_invoice_numnber_unique UNIQUE (invoice_numnber);


--
-- TOC entry 4487 (class 2606 OID 18874)
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- TOC entry 4489 (class 2606 OID 18899)
-- Name: payments payments_receipt_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_receipt_number_unique UNIQUE (receipt_number);


--
-- TOC entry 4481 (class 2606 OID 18832)
-- Name: perinatal_history perinatal_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.perinatal_history
    ADD CONSTRAINT perinatal_history_pkey PRIMARY KEY (id);


--
-- TOC entry 4422 (class 2606 OID 18401)
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 4424 (class 2606 OID 18404)
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- TOC entry 4431 (class 2606 OID 18431)
-- Name: relationships relationships_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.relationships
    ADD CONSTRAINT relationships_pkey PRIMARY KEY (id);


--
-- TOC entry 4429 (class 2606 OID 18422)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 4449 (class 2606 OID 18542)
-- Name: staff staff_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_email_unique UNIQUE (email);


--
-- TOC entry 4451 (class 2606 OID 18523)
-- Name: staff staff_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_pkey PRIMARY KEY (id);


--
-- TOC entry 4453 (class 2606 OID 18544)
-- Name: staff staff_staff_no_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_staff_no_unique UNIQUE (staff_no);


--
-- TOC entry 4455 (class 2606 OID 18540)
-- Name: staff staff_telephone_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_telephone_unique UNIQUE (telephone);


--
-- TOC entry 4461 (class 2606 OID 18613)
-- Name: triage_assessment triage_assessment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage_assessment
    ADD CONSTRAINT triage_assessment_pkey PRIMARY KEY (id);


--
-- TOC entry 4463 (class 2606 OID 18624)
-- Name: triage triage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage
    ADD CONSTRAINT triage_pkey PRIMARY KEY (id);


--
-- TOC entry 4412 (class 2606 OID 18371)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 4414 (class 2606 OID 18368)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4447 (class 2606 OID 18512)
-- Name: visit_type visit_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visit_type
    ADD CONSTRAINT visit_type_pkey PRIMARY KEY (id);


--
-- TOC entry 4459 (class 2606 OID 18579)
-- Name: visits visits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_pkey PRIMARY KEY (id);


--
-- TOC entry 4425 (class 1259 OID 18402)
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- TOC entry 4498 (class 2606 OID 18554)
-- Name: appointments appointments_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4499 (class 2606 OID 18559)
-- Name: appointments appointments_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4500 (class 2606 OID 18564)
-- Name: appointments appointments_staff_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.appointments
    ADD CONSTRAINT appointments_staff_id_foreign FOREIGN KEY (staff_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4516 (class 2606 OID 18714)
-- Name: behaviour_assessment behaviour_assessment_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.behaviour_assessment
    ADD CONSTRAINT behaviour_assessment_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4517 (class 2606 OID 18719)
-- Name: behaviour_assessment behaviour_assessment_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.behaviour_assessment
    ADD CONSTRAINT behaviour_assessment_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4518 (class 2606 OID 18709)
-- Name: behaviour_assessment behaviour_assessment_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.behaviour_assessment
    ADD CONSTRAINT behaviour_assessment_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4493 (class 2606 OID 18490)
-- Name: child_parent child_parent_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.child_parent
    ADD CONSTRAINT child_parent_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4494 (class 2606 OID 18485)
-- Name: child_parent child_parent_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.child_parent
    ADD CONSTRAINT child_parent_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.parents(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4492 (class 2606 OID 18467)
-- Name: children children_gender_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.children
    ADD CONSTRAINT children_gender_id_foreign FOREIGN KEY (gender_id) REFERENCES public.gender(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4522 (class 2606 OID 18766)
-- Name: cns cns_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cns
    ADD CONSTRAINT cns_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4523 (class 2606 OID 18771)
-- Name: cns cns_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cns
    ADD CONSTRAINT cns_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4524 (class 2606 OID 18761)
-- Name: cns cns_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cns
    ADD CONSTRAINT cns_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4525 (class 2606 OID 18792)
-- Name: development_assessment development_assessment_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_assessment
    ADD CONSTRAINT development_assessment_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4526 (class 2606 OID 18797)
-- Name: development_assessment development_assessment_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_assessment
    ADD CONSTRAINT development_assessment_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4527 (class 2606 OID 18787)
-- Name: development_assessment development_assessment_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_assessment
    ADD CONSTRAINT development_assessment_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4513 (class 2606 OID 18688)
-- Name: development_milestones development_milestones_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_milestones
    ADD CONSTRAINT development_milestones_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4514 (class 2606 OID 18693)
-- Name: development_milestones development_milestones_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_milestones
    ADD CONSTRAINT development_milestones_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4515 (class 2606 OID 18683)
-- Name: development_milestones development_milestones_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.development_milestones
    ADD CONSTRAINT development_milestones_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4510 (class 2606 OID 18662)
-- Name: diagnosis diagnosis_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diagnosis
    ADD CONSTRAINT diagnosis_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4511 (class 2606 OID 18667)
-- Name: diagnosis diagnosis_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diagnosis
    ADD CONSTRAINT diagnosis_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4512 (class 2606 OID 18656)
-- Name: diagnosis diagnosis_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diagnosis
    ADD CONSTRAINT diagnosis_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4519 (class 2606 OID 18740)
-- Name: family_social_history family_social_history_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.family_social_history
    ADD CONSTRAINT family_social_history_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4520 (class 2606 OID 18745)
-- Name: family_social_history family_social_history_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.family_social_history
    ADD CONSTRAINT family_social_history_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4521 (class 2606 OID 18735)
-- Name: family_social_history family_social_history_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.family_social_history
    ADD CONSTRAINT family_social_history_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4490 (class 2606 OID 18444)
-- Name: parents parents_gender_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parents
    ADD CONSTRAINT parents_gender_id_foreign FOREIGN KEY (gender_id) REFERENCES public.gender(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4491 (class 2606 OID 18449)
-- Name: parents parents_relationship_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parents
    ADD CONSTRAINT parents_relationship_id_foreign FOREIGN KEY (relationship_id) REFERENCES public.relationships(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4530 (class 2606 OID 18854)
-- Name: past_medical_history past_medical_history_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.past_medical_history
    ADD CONSTRAINT past_medical_history_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4531 (class 2606 OID 18859)
-- Name: past_medical_history past_medical_history_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.past_medical_history
    ADD CONSTRAINT past_medical_history_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4532 (class 2606 OID 18881)
-- Name: payments payments_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4533 (class 2606 OID 18891)
-- Name: payments payments_payment_mode_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_payment_mode_id_foreign FOREIGN KEY (payment_mode_id) REFERENCES public.payment_modes(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4534 (class 2606 OID 18886)
-- Name: payments payments_staff_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_staff_id_foreign FOREIGN KEY (staff_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4535 (class 2606 OID 18875)
-- Name: payments payments_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4528 (class 2606 OID 18833)
-- Name: perinatal_history perinatal_history_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.perinatal_history
    ADD CONSTRAINT perinatal_history_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4529 (class 2606 OID 18838)
-- Name: perinatal_history perinatal_history_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.perinatal_history
    ADD CONSTRAINT perinatal_history_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4495 (class 2606 OID 18524)
-- Name: staff staff_gender_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_gender_id_foreign FOREIGN KEY (gender_id) REFERENCES public.gender(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4496 (class 2606 OID 18529)
-- Name: staff staff_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4497 (class 2606 OID 18534)
-- Name: staff staff_specialization_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_specialization_id_foreign FOREIGN KEY (specialization_id) REFERENCES public.doctor_specialization(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4506 (class 2606 OID 18640)
-- Name: triage triage_assessment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage
    ADD CONSTRAINT triage_assessment_id_foreign FOREIGN KEY (assessment_id) REFERENCES public.triage_assessment(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4507 (class 2606 OID 18630)
-- Name: triage triage_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage
    ADD CONSTRAINT triage_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4508 (class 2606 OID 18635)
-- Name: triage triage_staff_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage
    ADD CONSTRAINT triage_staff_id_foreign FOREIGN KEY (staff_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4509 (class 2606 OID 18625)
-- Name: triage triage_visit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.triage
    ADD CONSTRAINT triage_visit_id_foreign FOREIGN KEY (visit_id) REFERENCES public.visits(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4501 (class 2606 OID 18600)
-- Name: visits visits_appointment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_appointment_id_foreign FOREIGN KEY (appointment_id) REFERENCES public.appointments(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4502 (class 2606 OID 18585)
-- Name: visits visits_child_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_child_id_foreign FOREIGN KEY (child_id) REFERENCES public.children(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 4503 (class 2606 OID 18595)
-- Name: visits visits_doctor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_doctor_id_foreign FOREIGN KEY (doctor_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4504 (class 2606 OID 18590)
-- Name: visits visits_staff_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_staff_id_foreign FOREIGN KEY (staff_id) REFERENCES public.staff(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 4505 (class 2606 OID 18580)
-- Name: visits visits_visit_type_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT visits_visit_type_foreign FOREIGN KEY (visit_type) REFERENCES public.visit_type(id) ON UPDATE CASCADE ON DELETE SET NULL;


-- Completed on 2024-12-30 23:59:01

--
-- PostgreSQL database dump complete
--

